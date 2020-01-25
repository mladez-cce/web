<?php

$latestPosts = get_posts([
	"orderby" => "date",
	"order" => "DESC",
	"posts_per_page" => 10,
]);

// Template for 'Homepage' as configured in 'Settings > Reading'
view([
	"latestPosts" => $latestPosts
]);
