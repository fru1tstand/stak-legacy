<?php
namespace stak;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";

class MockStakSettings extends StakSettings {
	/**
	 * Determines if debugging is enabled. Mainly used for debug messages, but also has some
	 * other side effects.
	 * @return bool
	 */
	public function enableDebug() {
		return true;
	}
}