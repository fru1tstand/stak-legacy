<?php
namespace common\template;
require_once $_SERVER['DOCUMENT_ROOT'] . '/.site/php/stak/Autoload.php';
use common\base\Response;

/**
 * Defines a template page
 * @package common\template
 */
interface ContentPage {
	/**
	 * Returns if the page can be loaded. This method is called before any HTML is sent. Headers
	 * and other information can be used. This method is where you should check for security and
	 * system state.
	 * @param Response $response
	 * @return bool True if the page can be loaded; false otherwise.
	 */
	public static function canLoad(Response &$response = null);

	/**
	 * Returns the location of the content (this method should not itself print any html).
	 * @return string
	 */
	public static function getContentLocation();
}