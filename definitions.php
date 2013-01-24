<?php
	// force UTF-8 Ø

	// For internal paths
	define('ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
	define('CLASS_PATH', ROOT_PATH . 'classes' . DIRECTORY_SEPARATOR);

	// For external paths
	define('URL_BASE', dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR);
	define('URL_PATH', '//' . $_SERVER['SERVER_NAME'] . URL_BASE);
?>
