<?php
//
// Template for 'Homepage' as configured in 'Settings > Reading'
//
// This is the actual home page of the website.

$latestPosts = get_posts([
	"orderby" => "date",
	"order" => "DESC",
	"posts_per_page" => 10,
]);

view([
	"latestPosts" => $latestPosts
]);
