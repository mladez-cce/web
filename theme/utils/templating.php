<?php
//
// Custom Latte filters.
//
// You can find all the available WordPress filters provided by Mango here:
// https://github.com/manGoweb/MangoPressTemplating/blob/09396d0f770da1d067744301f3e54532b27c6d6e/lib/filters.php
//

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
 * Returns a three-letter representation of a month.
 *
 * Usage: {$Post->start_date|date:'n'|wp_cz_month}
 *
 * @param string|int numeric month in a year (1-12)
 * @return SafeHtmlString
 */
MangoFilters::$set["wp_cz_month"] = function ($month) {
	$MONTHS = ["led", "úno", "bře", "dub", "kvě", "čvn", "čvc", "srp", "zář", "říj", "lis", "pro"];

	if (!array_key_exists(intval($month) - 1, $MONTHS)) {
		throw new InvalidArgumentException("This is not a valid month number: " . $month);
	}

	return $MONTHS[intval($month) - 1];
};
