<?php

/**
 * Returns a from / to string representation of an event's date.
 *
 * @param WP_Post $Post a WordPress post of the "event" type.
 * @return string the representation or empty if the post is not a valid event.
 */
function wml_get_event_date($Post) {
	if (empty($Post->start_date) || empty($Post->end_date)) {
		return "";
	}

	$startDate = date_create_from_format("Y-m-d", $Post->start_date);
	$endDate  = date_create_from_format("Y-m-d", $Post->end_date);

	if ($startDate == $endDate) {
		return $startDate->format("j. n. Y");
	}

	$sameMonth = $startDate->format("m") == $endDate->format("m");
	return
		($sameMonth ? $startDate->format("j.") : $startDate->format("j. n."))
		. " až " . $endDate->format("j. n. Y");
}
