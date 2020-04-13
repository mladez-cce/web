<?php

// Use relative paths when inserting media into posts. By default, WordPress
// adds the page domain to the URLs which makes it impossible to move the
// WordPress instance between domains.
add_filter('wp_get_attachment_url', function ($url) {
	return 	wp_make_link_relative($url);
});
