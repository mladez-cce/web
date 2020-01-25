<?php
//
// Template for the single event page
//

$relatedPosts = get_posts([
	"post_type" => "post",
	"meta_key" => "related_event",
	"meta_value" => get_the_ID(),
	"orderby" => "date",
	"order" => "DESC",
]);

view([
	"relatedPosts" => $relatedPosts
]);
