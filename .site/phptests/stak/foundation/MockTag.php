<?php
namespace stak\foundation;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use common\base\Response;

/**
 * Mock implementation of Tag that serves as a simple container. Also used to test the Tag
 * abstract class code since this class provides no new logic.
 * @package stak\foundation
 */
class MockTag extends Tag {

	/**
	 * Simple constructor
	 * @param $name The name of the tag
	 * @param $color The color of the tag in the format of RRGGBB
	 */
	public function __construct($name, $color) {
		$this->name = $name;
		$this->color = $color;
	}

	// Implementor methods. These all return true because we don't have any processing to do with
	// them in mock form.
	protected function updateName($name, Response &$response = null) {
		return true; }
	protected function updateColor($color, Response &$response = null) {
		return true; }
}
