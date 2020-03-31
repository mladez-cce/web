<?php

/**
 * Returns the current complete URL address just as it's shown in the URL bar.
 * @return string
 */
function wml_get_current_url() {
	// Although WordPress has APIs to obtain the current URL, this seems to work most reliably,
	// including the "nice" permalinks.
	return "//" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

/**
 * Returns HTML representation of a link. This is a copy-paste from WordPress' codebase.
 *
 * @param string $url
 * @param string $label
 * @param string $attr
 * @return string
 */
function wml_create_anchor_tag($url, $label, $attr) {
	return
		"<a href=\"" . $url . "\" " . $attr . ">" .
		preg_replace("/&([^#])(?![a-z]{1,8};)/i", "&#038;$1", $label) . "</a>";
}
