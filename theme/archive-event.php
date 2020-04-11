<?php
//
// Template for the "archive page" of the "event" post type (this is the calendar essentially).
//

/**
 * Returns the pagination link for previous events. If upcoming events are shown and this is the
 * first page (= the nearest upcoming events), the link switches to past events.
 *
 * @param string $label
 * @return string|void full HTML anchor tag for the previous page or NULL if there is none
 */
function get_previous_events_link($label = NULL) {
	// Past events are in reversed order.
	$previous_events_link = show_past_events()
		? get_next_posts_link($label)
		: get_previous_posts_link($label);

	if ($previous_events_link === NULL && !show_past_events()) {
		$previous_events_link =
			wml_create_anchor_tag(
				add_query_arg(SHOW_PAST_EVENTS_VARNAME, true, wml_get_current_url()),
				$label,
				apply_filters("next_posts_link_attributes", ""));
	}

	return $previous_events_link;
}

/**
 * Returns the pagination link for next events. If past events are shown and this is the first
 * page (= the latest past events), the link switches to upcoming events.
 *
 * @param string $label
 * @return string|void full HTML anchor tag for the next page or NULL if there is none
 */
function get_next_events_link($label = NULL) {
	// Past events are in reversed order.
	$next_events_link = show_past_events()
		? get_previous_posts_link($label)
		: get_next_posts_link($label);

	if ($next_events_link === NULL && show_past_events()) {
		$next_events_link =
			wml_create_anchor_tag(
				add_query_arg(SHOW_PAST_EVENTS_VARNAME, false, wml_get_current_url()),
				$label,
				apply_filters("next_posts_link_attributes", ""));
	}

	return $next_events_link;
}

view(NULL, [
	"previous_events_link" => get_previous_events_link("Předešlé události"),
	"next_events_link" => get_next_events_link("Následující události")]);
