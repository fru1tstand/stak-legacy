<?php
namespace common\milk\inject;
use \Exception;
use \ReflectionClass;

/**
 * Where the magic happens. This is used to create instances of the requested abstract class or
 * interface.
 * @package common\milk\inject
 */
class Injector {
	/* @var Binder[] */	private $binders;
	/* @var object[] */	private $singletonInstances;


	/**
	 * Creates an injector from the given mappings
	 * @param Binder[] $mapping
	 * @throws Exception
	 */
	public function __construct(array $mapping) {
		foreach ($mapping as $map)
			if (!($map instanceof Binder))
				throw new Exception("Mapping must be an array of binders");

		$this->binders = array();
		$this->singletonInstances = array();
		foreach ($mapping as $map) {
			$this->binders[$map->getAbstract()] = $map;
			$refClass = new ReflectionClass($map->getAbstract());
			/** @var ReflectionClass $refClass */
			while ($refClass = $refClass->getParentClass()) {
				$this->binders[$refClass->getName()] = $map;
			}
			if ($map->isSingleton())
				$this->singletonInstances[$map->getImplementation()] = null;
		}
	}

	/**
	 * Gets the instance of the class requested
	 * @param $name
	 * @return mixed
	 * @throws Exception Thrown when one or more Milk errors occur
	 */
	public function getInstance($name) {
		// Does the request abstract/interface exist?
		if (!class_exists($name) && !interface_exists($name))
			throw new Exception("'$name' doesn't exist.");

		// Do we have a binder for it?
		if (!isset($this->binders[$name]))
			throw new Exception("$name is unknown to me");

		// Get binder
		$binder = $this->binders[$name];

		// Check if it's a singleton and we have it instantiated already (simply return it)
		if ($binder->isSingleton()
			&& !is_null($this->singletonInstances[$binder->getImplementation()]))
			return $this->binders[$binder->getImplementation()];

		// Prepare to instantiate
		$class = new ReflectionClass($binder->getImplementation());
		$constructor = $class->getConstructor();
		$resultObject = null;

		// Check if it's a static implementation (no need to instantiate, simply return impl)
		if ($binder->isStatic())
			return $class->newInstanceWithoutConstructor();

		// No constructor or constructor with empty parameter listpage, we can simply create an instance
		if (is_null($constructor) || count($constructor->getParameters()) == 0) {
			$resultObject = $class->newInstance();
		}

		// Constructor with parameters
		else {
			$instanceArgs = array();

			// Get objects necessary to create the reflected class
			$parameters = $constructor->getParameters();
			foreach ($parameters as $param) {
				// Check if there is a type hint. If not, Milk can't instantiate it.
				if (is_null($param->getClass()))
					throw new Exception("'$name' doesn't seem to have a Milk-friendly constructor");

				// Recursive call to get instance objects as needed
				$instanceArgs[] = $this->getInstance($param->getClass());
			}

			// Finally, make the object
			$resultObject = $class->newInstanceArgs($instanceArgs);
		}

		// One last check
		if (is_null($resultObject))
			throw new Exception("I don't know what happened, but '$name' couldn't be instantiated");

		// If it's a singleton, save the instance
		if ($binder->isSingleton())
			$this->singletonInstances[$name] = &$resultObject;

		return $resultObject;
	}
}
