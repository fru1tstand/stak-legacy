<?php
define("PHP_PATH", $_SERVER['DOCUMENT_ROOT'] . '/.site/php', false);
define("PHP_SOURCE_PATH", PHP_PATH . "/source", false);
define("PHP_PAGES_PATH", PHP_PATH . "/pages", false);

//Create an autoload rule which will let the parser know how to find a class if
//it's undefined within the current scope.
spl_autoload_register(function($className) {
	//So we don't need to worry about window-linux directory-ing
	$className = str_replace("\\", "/", $className);
	include_once(PHP_SOURCE_PATH . "/" . $className . ".php");
});
?>
