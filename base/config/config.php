<?php

// Title of the page
define('TITLE', 'Base Site');

// Different URLs of the website
define('SERVER_URL', 'http://localhost');
define('BASE_STRING','/asterion/');
define('LOCAL_URL', SERVER_URL.BASE_STRING);
define('LOCAL_FILE', $_SERVER['DOCUMENT_ROOT'].BASE_STRING);
define('BASE_URL', LOCAL_URL.APP_FOLDER.'/');
define('BASE_FILE', LOCAL_FILE.APP_FOLDER.'/');
define('APP_URL', LOCAL_URL.'app/');
define('APP_FILE', LOCAL_FILE.'app/');

// Activate the debug
define('DEBUG', true);

// Languages
define('LANGS', 'en:es:fr');

// Session and cookies
define('SESSION_NAME', 'base-site');
session_start(SESSION_NAME);
define('COOKIE_TIME', 3600000);

// Url rewrites
define('ADMIN_URL_STRING', 'admin');
define('PAGER_URL_STRING', 'page');

// Folders
define('MODEL_FILE', BASE_FILE.'lib/');
define('FRAMEWORK_FILE', APP_FILE.'lib/');
define('ADMIN_URL', LOCAL_URL.ADMIN_URL_STRING.'/');
define('STOCK_URL', BASE_URL.'stock/');
define('STOCK_FILE', BASE_FILE.'stock/');
define('HELPERS_URL', APP_URL.'helpers/');
define('HELPERS_FILE', APP_FILE.'helpers/');

// Locations of the content objects
$_ENV['locations'][] = MODEL_FILE;
$_ENV['locations'][] = FRAMEWORK_FILE.'base/';
$_ENV['locations'][] = FRAMEWORK_FILE.'admin/';

// Database
define('DB_SERVER', 'localhost');
define('DB_USER', 'rodot');
define('DB_PASSWORD', 'lucyinthesky');
define('DB_PORT', '3306');
define('DB_NAME', 'asterion');
define('DB_TYPE', 'mysql');
define('DB_PREFIX', 'ast_');
define("PDO_DSN","mysql:host=".DB_SERVER.";port=".DB_PORT.";dbname=".DB_NAME);

// Images
define('LOGO', BASE_URL.'visual/img/logo.jpg');
define('WIDTH_HUGE', 1600);
define('HEIGHT_MAX_HUGE', 2400);
define('WIDTH_WEB', 600);
define('HEIGHT_MAX_WEB', 1400);
define('WIDTH_SMALL', 250);
define('HEIGHT_MAX_SMALL', 500);
define('WIDTH_THUMB', 120);
define('HEIGHT_MAX_THUMB', 120);
define('WIDTH_SQUARE', 100);

// Email
define('EMAIL', 'info@asterion-cms.com');

// Load the helpers
mb_internal_encoding('UTF-8');
require_once(APP_FILE.'helpers/autoload.php');
require_once(APP_FILE.'helpers/phpHelper.php');

?>