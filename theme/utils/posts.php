<?php

/**
 * Returns a WP_Post object for the input.
 *
 * @param WP_Post|int $id
 * @return WP_Post|null
 */
function wml_lazy_post($id) {
	if ($id instanceof WP_Post) {
		return $id;
	}

	if (is_numeric($id)) {
		return get_post($id);
	}

	throw new InvalidArgumentException("Unable to return WP Post");
}
