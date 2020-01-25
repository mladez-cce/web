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
