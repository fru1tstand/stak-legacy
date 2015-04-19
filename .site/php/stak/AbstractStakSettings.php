<?php
namespace stak;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use common\base\AbstractSettings;

/**
 * Defines settings for an instance of stak
 * @package stak
 */
abstract class AbstractStakSettings extends AbstractSettings {
	const STAK_SESSION_NAME = "fru1tme-stak";

	/**
	 * Gets the web session name to use
	 * @return string
	 */
	public function getWebSessionName() {
		return self::STAK_SESSION_NAME;
	}
}