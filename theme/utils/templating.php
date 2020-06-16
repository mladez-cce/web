<?php
//
// Custom Latte filters.
//
// You can find all the available WordPress filters provided by Mango here:
// https://github.com/manGoweb/MangoPressTemplating/blob/09396d0f770da1d067744301f3e54532b27c6d6e/lib/filters.php
//

/**
 * Returns the display name of the post author.
 *
 * Usage: {$post|wp_author}
 *
 * @param int|WP_Post $post
 * @return SafeHtmlString
 */
MangoFilters::$set["wp_author"] = function ($post) {
	$authorId = get_post_field("post_author", $post);
	return safe(
		$authorId ? get_userdata($authorId)->display_name : "neznámý uživatel");
};

/**
 * Returns the display name of the author that modified the post last.
 *
 * Usage: {$post|wp_last_modified_author}
 *
 * @param int|WP_Post $post
 * @return SafeHtmlString
 */
MangoFilters::$set["wp_last_modified_author"] = function ($post) {
	$authorId = get_post_meta(
		wml_lazy_post($post)->ID, '_edit_last', /* single = */ true);
	return safe(
		$authorId ? get_userdata($authorId)->display_name : "neznámý uživatel");
};

/**
 * Returns the post excerpt.
 *
 * This overrides the existing Mango filter as it doesn't support automatic excerpts.
 *
 * Usage: {$post|wp_excerpt}
 * More info: https://wordpress.org/support/article/excerpt/
 *
 * @param int|WP_Post $post
 * @return SafeHtmlString
 */
MangoFilters::$set["wp_excerpt"] = function ($post) {
	return safe(get_the_excerpt($post));
};

/**
 * Returns the date on which the post was written.
 *
 * Usage: {$post|wp_modified_date}
 *
 * @param int|WP_Post $post
 * @return string|void
 */
MangoFilters::$set["wp_date"] = function ($post) {
	return get_the_date(/* format = */ "", $post);
};

/**
 * Returns the post last modified date.
 *
 * Usage: {$post|wp_modified_date}
 *
 * @param int|WP_Post $post
 * @return string|void
 */
MangoFilters::$set["wp_modified_date"] = function ($post) {
	return get_the_modified_date(/* format = */ "", $post);
};

/**
 * Returns a Czech three-letter representation of the month.
 *
 * Usage: {$Post|wp_date|wp_short_month_cz_name}
 *
 * @param DateTime|int|string $date
 * @return SafeHtmlString
 */
MangoFilters::$set["wp_short_month_cz_name"] = function ($date) {
	return safe(wml_get_short_month_cz_name(wml_to_datetime($date)));
};

/**
 * Returns a from / to string representation of an event's date.
 *
 * @param WP_Post|int $id a WordPress post (or its id) of the "event" type.
 * @return string the representation or empty if the post is not a valid event.
 * @throws Exception
 */
MangoFilters::$set["wp_event_date"] = function ($id) {
	$post = wml_lazy_post($id);

	if (empty($post->start_date) || empty($post->end_date)) {
		return "";
	}

	$startDate = wml_to_datetime($post->start_date);
	$endDate = wml_to_datetime($post->end_date);

	if ($startDate == $endDate) {
		return wml_get_cz_date_format($startDate);
	}

	$sameMonth = $startDate->format("m") == $endDate->format("m");

	return $startDate->format("j. ")
		. ($sameMonth ? "" : wml_get_month_cz_name_for_date($startDate) . " ")
		. "až "
		. wml_get_cz_date_format($endDate);
};
