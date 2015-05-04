<?php
namespace stak\foundation;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use common\base\Response;

/**
 * It's an empty tag!
 *
 * @package stak\foundation
 */
class EmptyTag extends Tag {
	private $isSortedToFront;

	public function __construct($name, $color, $isSortedToFront) {
		$this->name = $name;
		$this->color = $color;
		$this->isSortedToFront = !!$isSortedToFront;
	}

	/**
	 * Empty tag sort is set by user settings
	 * @param Tag $other
	 * @return int
	 */
	public function compareAlphabetical(Tag $other) {
		return (($this->isSortedToFront) ? -1 : 1);
	}

	// Updaters
	/**
	 * Called when {@link setName} is called.
	 *
	 * @param          $name
	 * @param Response $response
	 *
	 * @return bool True on success; false otherwise.
	 */
	protected function updateName($name, Response $response = null) {
		return false;
	}

	/**
	 * Called when {@link setColor} is called.
	 *
	 * @param          $color
	 * @param Response $response
	 *
	 * @return bool True on success; false otherwise.
	 */
	protected function updateColor($color, Response $response = null) {
		return false;
	}

}
