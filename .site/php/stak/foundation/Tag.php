<?php
namespace stak\foundation;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use common\base\Response;
use common\security\Hashable;

/**
 * A label that can be attached to a Task
 * @package stak\foundation
 */
abstract class Tag implements Hashable {
	// Constants
	const NAME_MAX_LENGTH = 128;

	// Tag fields
	/* @var string */	protected $name;
	/* @var string */	protected $color;


	// Getters
	/**
	 * Gets the tag name
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Gets the tag color in the format of "RRGGBB" or null if no color is set.
	 * @return string
	 */
	public function getColor() {
		return $this->color;
	}


	//Setters
	/**
	 * Attempts to set the name of the tag.
	 * @param          $name
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	public function setName($name, Response $response = null) {
		Response::getInstance($response, "Tag::setName");

		if (!self::isValidName($name, $response))
			return false;

		if (!$this->updateName($name, $response))
			return false;

		$this->name = $name;
		return true;
	}

	/**
	 * Attempts to set the color of the tag.
	 * @param          $color
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	public function setColor($color, Response $response = null) {
		Response::getInstance($response, "Tag::setColor");

		if (!self::isValidColor($color, $response))
			return false;

		// Some styling first
		$color = strtoupper($color);

		if (!$this->updateColor($color, $response))
			return false;

		$this->color = $color;
		return true;
	}


	// Other
	public function getHash() {
		return md5("Name: {$this->getName()}");
	}


	// Sorters
	/**
	 * Compares this Tag to the passed Tag returning a negative number if this tag should come
	 * before the other in chronological order
	 * @param Tag $other
	 * @return int
	 */
	public function compareAlphabetical(Tag $other) {
		return strcmp($this->name, $other->name);
	}


	//Validation
	/**
	 * Checks if the given value is a valid title.
	 * @param          $name
	 * @param Response $response
	 * @return bool True if valid; false otherwise.
	 */
	public static function isValidName($name, Response $response = null) {
		Response::getInstance($response, "Tag::isValidTitle");

		if (strlen($name) < 1)
			$response->addError("A tag name must have some characters");

		if (strlen($name) > self::NAME_MAX_LENGTH)
			$response->addError("A tag name can't be longer than " . self::NAME_MAX_LENGTH .
								"characters");

		return !$response->hasFailed();
	}

	/**
	 * Checks if the given value is a valid hex CSS color in the format of "RRGGBB".
	 * @param null     $color
	 * @param Response $response
	 * @return bool True if valid; false otherwise.
	 */
	public static function isValidColor($color = null, Response $response = null) {
		Response::getInstance($response, "Tag::isValidColorInt");

		if (is_null($color))
			return true;

		if (!preg_match("/[0-9a-fA-F]{6}/", $color))
			$response->addError("I don't understand the color '$color'");

		return !$response->hasFailed();
	}


	//Implementor propagation methods. See Task for full details.
	/**
	 * Called when {@link setName} is called.
	 * @param          $name
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	protected abstract function updateName($name, Response $response = null);

	/**
	 * Called when {@link setColor} is called.
	 * @param          $color
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	protected abstract function updateColor($color, Response $response = null);
}
