<?php

// Modify the "Read more" string, which is appended to post excerpts to indicate
// that there is more to read.
//
// Ideally, we'd append an actual link but as we don't have access here to the
// concrete post (only the global one), all we can do is a generic string. It's
// marked with a CSS class so that we can add that link via some CSS magic.
add_filter("excerpt_more", function () {
	return "<span class='wp-excerpt-more'>...</span>";
});

// Ignore "sticky posts", i.e., highlighted posts that will remain at the top
// regardless of their publish date. Given the structure of the site (we have
// events and news), this feature doesn't make that much sense.
add_action("pre_get_posts", function ($query) {
	if ($query->is_main_query()) {
		$query->set("ignore_sticky_posts", true);
	}
});
