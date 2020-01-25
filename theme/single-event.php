<?php

$relatedPosts = get_posts([
	"post_type" => "post",
	"meta_key" => "related_event",
	"meta_value" => get_the_ID(),
	"orderby" => "date",
	"order" => "DESC",
]);

// Template for a single event page
view([
	"relatedPosts" => $relatedPosts
]);
