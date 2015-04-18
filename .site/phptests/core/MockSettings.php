<?php
namespace core;


class MockSettings extends Settings {
	/**
	 * Sets up dependencies
	 */
	public function setup() {
		// TODO: Implement setup() method.
	}

	/**
	 * Enables debugging mode which allows debug messages to be stored.
	 * @return bool
	 */
	protected function enableDebug() {
		return true;
	}

	/**
	 * Set to true to enable inclusion of test folders. (We don't want mocks and other testing
	 * files in production)
	 * @return bool
	 */
	protected function includeTests() {
		return true;
	}
}