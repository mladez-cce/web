<?php

use Nette\Utils\Html;

function safe($content) {
	return Html::el()->setHtml($content);
}

MangoFilters::$set['url'] = 'rawurlencode';

foreach (array('normalize', 'toAscii', 'webalize', 'padLeft', 'padRight', 'reverse') as $name) {
	MangoFilters::$set[$name] = 'Nette\Utils\Strings::' . $name;
}

MangoFilters::$set['null'] = function () {};

MangoFilters::$set['length'] = function ($var) {
	return is_string($var) ? Nette\Utils\Strings::length($var) : count($var);
};

MangoFilters::$set['modifyDate'] = function ($time, $delta, $unit = NULL) {
	return $time == NULL ? NULL : Nette\Utils\DateTime::from($time)->modify($delta . $unit); // intentionally ==
};

function lazy_post($id) {
	if(is_object($id)) {
		return $id;
	}
	return get_post($id);
}

MangoFilters::$set['wp_title'] = function($id) {
	$post = lazy_post($id);
	if(!$post) return $id;

	return safe(apply_filters('the_title', $post->post_title, $post->ID));
};

MangoFilters::$set['wp_content'] = function($id) {
	$post = lazy_post($id);
	if(!$post) return $id;

	return safe(apply_filters('the_content', $post->post_content));
};

MangoFilters::$set['wp_excerpt'] = function($id) {
	$post = lazy_post($id);
	if(!$post) return $id;

	return safe(apply_filters('the_excerpt', $post->post_excerpt));
};

MangoFilters::$set['wp_permalink'] = function($id) {
	$post = lazy_post($id);
	if(!$post) return $id;

	return get_permalink($id);
};

MangoFilters::$set['wp_date'] = function($id, $format = null) {
	$post = lazy_post($id);
	if(!$post) return $id;

	$date = new Nette\Utils\DateTime($post->post_date);

	if($format) {
		return $date->format($format);
	} else {
		return $date->format(get_option('date_format'));
	}
};

MangoFilters::$set['wp_DateTime'] = function($id, $format = null) {
	$post = lazy_post($id);
	if(!$post) return $id;

	return new Nette\Utils\DateTime($post->post_date);
};

MangoFilters::$set['wp_meta'] = function($id, $meta, $as = null) {
	$post = lazy_post($id);
	if(!$post) return $id;

	return get_field($post->ID, $meta, $as);
};

MangoFilters::$set['wp_terms'] = function($id, $taxonomy, $delimiter = ', ') {
	$post = lazy_post($id);
	if(!$post) return $id;

	$terms = wp_get_post_terms($post->ID, $taxonomy, [ 'fields' => 'names' ]);

	return html_entity_decode(implode($delimiter, $terms));
};

MangoFilters::$set['wp_meta_list'] = function($id, $meta) {
	$post = lazy_post($id);
	if(!$post) return $id;

	return get_post_meta($post->ID, $meta, FALSE);
};

MangoFilters::$set['wp_image'] = function($id, $size = 'thumbnail') {
	$post = lazy_post($id);
	if(!$post) return $id;

	return wp_get_attachment_image_src($post->ID, $size)[0]
		? wp_get_attachment_image_src($post->ID, $size)[0]
		: '';
};

MangoFilters::$set['wp_thumbnail'] = function($id, $size = 'thumbnail') {
	$post = lazy_post($id);
	if(!$post) return $id;

	return isset(wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $size)[0])
		? wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $size)[0]
		: '';
};

MangoFilters::$set['wp_esc'] = function($str) {
	return html_entity_decode($str);
};

MangoFilters::$set['number'] = function($number, $decimal = 2) {
	if(fmod($number, 1) == 0) {
		$decimal = 0;
	}
	$sep = '.';
	$formatted = number_format($number, $decimal, $sep, ",");
	if($decimal) {
		$formatted = Strings::replace($formatted, '~\.?0$~');
	}

	return $formatted;
};

function nbsp($str) {
	$str = trim($str);
	return Nette\Utils\Strings::replace($str, '~[ ]~', "\xc2\xa0");
}

MangoFilters::$set['nbsp'] = 'nbsp';
