<?php
//
// Custom WordPress configuration.
//
// This is just a loader; put your actual configuration in theme/functions.
//

// Load Mango stuff from config/utils
initTheme();

// Load stuff from theme/functions
foreach (glob(__DIR__ . "/functions/*.php") as $filepath) {
	require_once $filepath;
}
