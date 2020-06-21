<?php

//
// DO NOT CHANGE THE CONFIGURATION HERE. Use ../config/config.local.neon instead.
//

$App = require __DIR__ . '/../config/bootstrap.php';

$databaseParams = $App->parameters['database'];
$wpParams = $App->parameters['wp'] ?? [];
$s3Params = $App->parameters['s3'] ?? [];

define('DB_NAME', $databaseParams['database']);
define('DB_USER', $databaseParams['username']);
define('DB_PASSWORD', $databaseParams['password']);
define('DB_HOST', $databaseParams['host']);
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

if (!$App->parameters['consoleMode']) {
	define('WP_HOME', rtrim($wpParams['WP_HOME'] ?? $Url->getBaseUrl(), '/'));
	define('WP_SITEURL', rtrim($Url->getBaseUrl(), '/'));
}

define('WP_DEFAULT_THEME', 'theme');

define('AUTH_KEY', $wpParams['AUTH_KEY'] ?? 'put your unique phrase here');
define('SECURE_AUTH_KEY', $wpParams['SECURE_AUTH_KEY'] ?? 'put your unique phrase here');
define('LOGGED_IN_KEY', $wpParams['LOGGED_IN_KEY'] ?? 'put your unique phrase here');
define('NONCE_KEY', $wpParams['NONCE_KEY'] ?? 'put your unique phrase here');
define('AUTH_SALT', $wpParams['AUTH_SALT'] ?? 'put your unique phrase here');
define('SECURE_AUTH_SALT', $wpParams['SECURE_AUTH_SALT'] ?? 'put your unique phrase here');
define('LOGGED_IN_SALT', $wpParams['LOGGED_IN_SALT'] ?? 'put your unique phrase here');
define('NONCE_SALT', $wpParams['NONCE_SALT'] ?? 'put your unique phrase here');

$table_prefix = 'wp_';

define('WP_DEBUG', $App->parameters['debug']);
define('SCRIPT_DEBUG', $App->parameters['debug']);

if (!defined('ABSPATH')) {
	define('ABSPATH', dirname(__FILE__) . '/public/');
}

require_once ABSPATH . 'wp-settings.php';
