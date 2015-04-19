<?php
namespace common\base;

/**
 * Convenience methods for sanitation and input checks
 * @package common\base
 */
class Preconditions {
	// Arrays
	public static function arrayNullInvalidOrEmpty($array) {
		return is_null($array) || !is_array($array) || count($array) == 0;
	}
}