<?php
namespace stak\template\utils;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";

/**
 * Just some stak template utils
 * @package stak\template\utils
 */
class TemplateUtils {
	/**
	 * Gets the absolute path for the template/content folder.
	 * @return string
	 */
	public static function getContentLocation() {
		return $_SERVER['DOCUMENT_ROOT'] . "/.site/php/stak/template/content";
	}

	/**
	 * Includes the file specified by the parameter.
	 * @param $relativePathFromContentFolder
	 */
	public static function includeFromContentLocation($relativePathFromContentFolder) {
		/** @noinspection PhpIncludeInspection */
		include self::getContentLocation() . $relativePathFromContentFolder;
	}
}