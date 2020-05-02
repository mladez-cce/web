<?php

/**
 * Returns if an event is over (it's end date is in the past).
 *
 * @param WP_Post $Post a WordPress post of the "event" type.
 * @return bool true if the event is over or if $Post is not a valid event.
 */
function wml_is_event_over($Post) {
	if (empty($Post->end_date)) {
		return true;
	}

	return date_create_from_format("Y-m-d", $Post->end_date) < date_create("now");
}
