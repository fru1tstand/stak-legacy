<?php
namespace common\milk\inject;

/**
 * Sets up dependencies
 * @package common\milk\inject
 * @see Milk
 */
abstract class AbstractModule {
	private $bindMap;

	public function __construct() {
		//Setup dependencies
		$this->configure();
	}

	/**
	 * Starts the milking process.
	 * @param string $fullyQualifiedClassName The binding class (abstract class/interface)
	 * @return Binder
	 */
	protected function bind($fullyQualifiedClassName) {
		return new Binder($fullyQualifiedClassName, $this);
	}

	/**
	 * @param Binder $binder
	 */
	public function completeBind(Binder $binder) {
		if (!is_array($this->bindMap))
			$this->bindMap = array();
		$this->bindMap[] = $binder;
	}

	/**
	 * @return Binder[]
	 */
	public function getMap() {
		if (!is_array($this->bindMap))
			return array();
		return $this->bindMap;
	}

	public abstract function configure();
}