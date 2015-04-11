<?php
namespace content;
require_once $_SERVER['DOCUMENT_ROOT'] . '/.site/php/utils/Autoload.php';

class IncludePage {
	
	//Singleton
	private function __construct() { }
	
	private static $validation = false;
	
	/**
	 * Validates an included page.
	 * Every content page calls this to make sure it was internally included.
	 * This prevents the page from being called directly through web url.
	 * @param string $val
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