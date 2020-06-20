<?php


function set_html_content_type()
{
	return 'text/html';
}


function send_mail($email, $subject, $view, $parameters = [])
{
	$content = viewString($view, $parameters);
	add_filter('wp_mail_content_type', 'set_html_content_type');
	wp_mail($email, $subject, $content);
	remove_filter('wp_mail_content_type', 'set_html_content_type');
}
