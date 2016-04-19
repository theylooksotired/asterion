<?php
//Configure site
define('APP_FOLDER', 'base');
require_once(APP_FOLDER.'/config/config.php');

//Initialize basic services
if (DEBUG) {
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	Init::initSite();
}
Url::init();
Lang::init();
Params::init();

//Get informations from the controller
try {
	$control = Controller_Factory::factory($_GET, $_POST, $_FILES);
	$content = $control->controlActions();
	$title = $control->getTitle();
	$header = $control->getHeader();
	$metaKeywords = $control->getMetaKeywords();
	$metaDescription = $control->getMetaDescription();
	$metaImage = $control->getMetaImage();
	$mode = $control->getMode();
} catch (Exception $e) {
	$content = '<pre>'.$e->getMessage().'</pre>';
	$content .= (DEBUG) ? '<pre>'.$e->getTraceAsString().'</pre>' : '';
}

//Select the visualization mode and return the formatted content
$mode = isset($mode) ? $mode : 'public';
switch ($mode) {
	default:
		$file = BASE_FILE.'visual/templates/'.$mode.'.php';
		if (file_exists($file)) {
			include($file);
		}
	break;
	case 'admin':
		include APP_FILE.'visual/templates/admin.php';
	break;
	case 'ajax':
		echo $content;
	break;
	case 'json':
		header('Content-Type: application/json');
		echo $content;
	break;
}
?>