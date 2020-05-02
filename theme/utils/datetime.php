<?php
define(
	"CZ_SHORT_MONTH_NAME",
	["led", "úno", "bře", "dub", "kvě", "čvn", "čvc", "srp", "zář", "říj", "lis", "pro"]);

define(
	"CZ_MONTH_NAME_FOR_DATE",
	["ledna", "února", "března", "dubna", "května", "června", "července", "srpna", "září", "října", "listopadu", "prosince"]);

/**
 * Converts time input into a valid DateTime object. The input time can be
 * represented as UNIX timestamp, string or already a DateTime object.
 *
 * @param DateTime|int|string $input
 * @return DateTime|false
 * @throws Exception
 */
function wml_to_datetime($input) {
	if ($input instanceof DateTime) {
		return $input;
	}

	if (is_numeric($input)) {
		$datetime = new DateTime('@' . $input);
		$datetime->setTimeZone(new \DateTimeZone(date_default_timezone_get()));
		return $datetime;
	}

	if (is_string($input)) {
		$datetime = date_create($input);

		if ($datetime !== false) {
			return $datetime;
		}
	} // fall through in case of error

	throw new InvalidArgumentException("Unable to convert input to DateTime");
}

/**
 * Returns a Czech three-letter representation of the month.
 *
 * @param DateTime $datetime
 * @return string
 */
function wml_get_short_month_cz_name($datetime) {
	return CZ_SHORT_MONTH_NAME[intval($datetime->format("n")) - 1];
}

/**
 * Returns a Czech name for the month, to be used in a date, e.g. "prosince".
 *
 * @param DateTime $datetime
 * @return string
 */
function wml_get_month_cz_name_for_date($datetime) {
	return CZ_MONTH_NAME_FOR_DATE[intval($datetime->format("n")) - 1];
}

/**
 * Returns date in the common Czech format, e.g. 24. prosince 2019.
 *
 * @param DateTime $datetime
 * @return string
 */
function wml_get_cz_date_format($datetime) {
	return $datetime->format("j. ")
		. wml_get_month_cz_name_for_date($datetime)
		. " "
		. $datetime->format("Y");
}
