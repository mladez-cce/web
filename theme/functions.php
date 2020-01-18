<?php

initTheme();

// TODO(tobik): Figure out how to structure this better.

// Name of the show_past_events query variable which determines whether the event archive page
// should show past or upcoming events.
define("SHOW_PAST_EVENTS_VARNAME", "show_past_events");

/**
 * Returns the current complete URL address just as it's shown in the URL bar.
 * @return string
 */
function get_current_url() {
	global $wp;
	return add_query_arg($wp->query_vars, home_url());
}

/**
 * Returns whether to show past events based on the show_past_events query variable.
 * @return bool
 */
function show_past_events() {
	return get_query_var(SHOW_PAST_EVENTS_VARNAME) === "1";
}

// Enable categories for our custom "event" post type.
add_action("init", function() {
	register_taxonomy_for_object_type("category", "event");
});

// Register show_past_events query variable to determine whether the event archive page should
// show past or upcoming events.
add_filter("query_vars", function ($query_vars) {
	$query_vars[] = SHOW_PAST_EVENTS_VARNAME;
	return $query_vars;
});

// Configure the WP query for events.
//
// The tricky thing about events is that we want the first / default page in the archive to show
// the nearest upcoming events. The user can navigate either to more distant upcoming events or to
// past events. This is impossible to do with default WordPress' pagination mechanism. Therefore we
// use the show_past_events variable to select either past or upcoming events and then let WordPress
// handle the pagination.
add_action("pre_get_posts", function ($query) {
	if ($query->is_main_query() && !is_admin() && is_post_type_archive("event"))	{

		// Select either upcoming or past events based on the show_past_events query variable.
		$query->set("meta_query", [
			"key" => "end_date",
			"value" => date("Y-m-d"),
			"compare" => show_past_events() ? "<" : ">=",
		]);

		// The actual ordering is inverted when showing past events, so we need to update the query
		// accordingly.
		$query->set("meta_key", "start_date");
		$query->set("orderby", "meta_value");
		$query->set("order", show_past_events() ? "DESC" : "ASC");
	}
});
