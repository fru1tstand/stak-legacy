<?php
namespace stak;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/Autoload.php";
use core\Response;

/**
 * Mock implementation of Tag that serves as a simple container. Also used to test the Tag
 * abstract class code since this class provides no new logic.
 * @package core
 */
class MockTag extends Tag {

	// Implementor methods. These all return true because we don't have any processing to do with
	// them in mock form.
	protected function updateName($name, Response &$response = null) {
		return true; }
	protected function updateColor($color, Response &$response = null) {
		return true; }
}