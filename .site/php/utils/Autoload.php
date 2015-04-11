<?php
namespace utils;


/**
 * This file serves as an overarching container for the site. It provides a means of
 * autoloading dependencies, as well as starting the session, etc. It is included
 * in every PHP file.
 */

define("PHP_PATH", $_SERVER['DOCUMENT_ROOT'] . '/.site/php', false);
define("PHP_CONTENT_PATH", PHP_PATH . "/content");
define("STAK_SESSION_NAME", "me-fru1t-stak");

//Auto-includes classes that aren't known to the interpreter at runtime.
spl_autoload_register(function($className) {
	//So we don't need to worry about window-linux directory-ing
	$className = str_replace("\\", "/", $className);
	include_once(PHP_PATH . "/" . $className . ".php");
});

//Starts the session
\pagedata\Session::start(STAK_SESSION_NAME);
?>
