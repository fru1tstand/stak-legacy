<?php
namespace content;
require_once $_SERVER['DOCUMENT_ROOT'] . '/.site/php/Autoload.php';

class IncludePage {

	//Singleton
	private function __construct() { }

	private static $validation = false;

	/**
	 * Validates an included content page. All pages (templates) must call this. This prevents
	 * loading a template from outside an include statement internally. (eg. Through web URL).
	 * @return bool True if valid import; false otherwise.
	 */
	public static function validate() {
		$r = self::$validation;
		self::$validation = false;
		return $r;
	}

	// *** Templates
	public static function ListTemplate() {
		self::$validation = true;
		include \PHP_CONTENT_PATH . "/page/templates/List.php";
	}
}
?>