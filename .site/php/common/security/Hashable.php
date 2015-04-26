<?php
namespace common\security;

/**
 * Defines a hashable object
 * @package common\security
 */
interface Hashable {
	/**
	 * Returns a hash of the object
	 * @return string
	 */
	public function getHash();
}