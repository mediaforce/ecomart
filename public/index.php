<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
header("Access-Control-Allow-Origin: https://pagseguro.uol.com.br");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

date_default_timezone_set("UTC");

if (getenv('APPLICATION_ENV') === 'production') {
defined('BUILD_PATH')
|| define('BUILD_PATH', '../');
defined('BUILD_PATH_VIEW')
|| define('BUILD_PATH_VIEW', '/../../build/module/Application');
} else {
defined('BUILD_PATH')
|| define('BUILD_PATH', '');
defined('BUILD_PATH_VIEW')
|| define('BUILD_PATH_VIEW', '');
}

chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
	$path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
	if (__FILE__ !== $path && is_file($path)) {
		return false;
	}
	unset($path);
}

// Setup autoloading
require BUILD_PATH . 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require BUILD_PATH . 'config/application.config.php')->run();