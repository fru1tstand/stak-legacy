<?php
/**
 * This file serves as an init file. It provides missing dependencies and sets up sessions,
 * constants, etc before any other php script runs. It is included in every PHP file.
 */

define("PHP_PATH", $_SERVER['DOCUMENT_ROOT'] . '/.site/php', false);
define("STAK_SESSION_NAME", "me-fru1t-stak");

// Auto-includes classes that aren't known to the interpreter at runtime.
spl_autoload_register(function($className) {
	//So we don't need to worry about window-linux directory-ing
	$className = str_replace("\\", "/", $className);
	include_once(PHP_PATH . "/" . $className . ".php");
});

// Placing these here AFTER the autoload definition.
use core\Settings;
use data\Session;

// Set up dependency injection modules with the settings. Also set settings instance. This mess
// is here to remind myself that in prod, we'd never do something so horrid.
// TODO: production, replace MockSettings with ProdSettings or something
include PHP_PATH . "tests/core/MockSettings.php";
$settings = new \core\MockSettings();
Settings::setInstance($settings);
$settings->setup();

if (Settings::INCLUDE_TESTS()) {
	spl_autoload_register(function($className) {
		$className = str_replace("\\", "/", $className);
		include_once(PHP_PATH . "tests/" . $className . ".php");
	});
}

// Start the stak session
Session::start(STAK_SESSION_NAME);
