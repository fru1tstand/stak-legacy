<?php
namespace common\Milk\inject;
use \Exception;

/**
 * Class Binder
 * @package common\Milk\inject
 * @see Milk
 */
class Binder {
	// Instance fields and methods
	/* @var string */			private $abstract;
	/* @var string */			private $implementation;
	/* @var bool */				private $isSingleton;
	/* @var AbstractModule */	private $module;


	// Setters
	/**
	 * Creates a binder with the given fully qualified class name. We bind from abstract to
	 * implementation.
	 * @param string $fullyQualifiedName The host (abstract class/interface)
	 * @param AbstractModule $module The calling module
	 * @throws Exception Thrown if passed class could not be found.
	 * @return Binder
	 */
	public function __construct($fullyQualifiedName, AbstractModule &$module) {
		if (!class_exists($fullyQualifiedName) && !interface_exists($fullyQualifiedName))
			throw new Exception("I don't recognize the class called '$fullyQualifiedName'");
		$this->isSingleton = false;
		$this->abstract = $fullyQualifiedName;
		$this->module = &$module;
		return $this;
	}

	/**
	 * Completes a mapping from the bound class to this passed class as a singleton instance when
	 * created.
	 * @param string $fullyQualifiedClassName The target (implementation)
	 * @throws Exception Thrown if passed class could not be found.
	 */
	public function asSingletonTo($fullyQualifiedClassName) {
		$this->isSingleton = true;
		$this->to($fullyQualifiedClassName);
	}

	/**
	 * Completes a mapping from the bound class to this passed class.
	 * @param string $fullyQualifiedName The target (implementation)
	 * @throws Exception Thrown if passed class could not be found.
	 */
	public function to($fullyQualifiedName) {
		if (!class_exists($fullyQualifiedName) && !interface_exists($fullyQualifiedName))
			throw new Exception("I don't recognize the class called '$fullyQualifiedName'");

		$this->implementation = $fullyQualifiedName;

		// Complete bind and set referring module to null. This helps with the debugging.
		$this->module->completeBind($this);
		$this->module = null;
	}


	// Because PHP doesn't have real packages (Java style), we have to have getters
	/**
	 * @return string
	 */
	public function getAbstract() {
		return $this->abstract;
	}

	/**
	 * @return string
	 */
	public function getImplementation() {
		return $this->implementation;
	}

	/**
	 * @return bool
	 */
	public function isSingleton() {
		return $this->isSingleton;
	}
}