<?php
/**
 * Reflection
 */

namespace Tests;

class Reflection
{
	/** @var \ReflectionClass|\ReflectionObject */
	protected $reflection;

	/** @var object */
	protected $instance;


	/**
	 * @param string|object $class
	 * @throws \InvalidArgumentException
	 */
	public function __construct($class)
	{
		if (is_object($class)) {
			$this->reflection = new \ReflectionObject($class);
			$this->instance = $class;

		} elseif (is_string($class) && class_exists($class)) {
			$this->reflection = new \ReflectionClass($class);

		} else {
			throw new \InvalidArgumentException('The class "' . $class . '" not exists.');
		}
	}


	/**
	 * @param string $name
	 * @param object|null $instance
	 * @return mixed
	 */
	public function getValue($name, $instance = NULL)
	{
		if (!isset($instance)) {
			$instance = $this->instance;
		}

		$property = $this->getProperty($name);

		if (!$property->isPublic()) {
			$property->setAccessible(TRUE);
		}

		return $property->getValue($instance);
	}


	/**
	 * @param string $name
	 * @param mixed $value
	 * @param object|null $instance
	 */
	public function setValue($name, $value, $instance = NULL)
	{
		if (!isset($instance)) {
			$instance = $this->instance;
		}

		if (strpos($name, '[')) {
			list($name, $value) = $this->nameIsArray($name, $value, $instance);
		}

		$property = $this->getProperty($name);

		if (!$property->isPublic()) {
			$property->setAccessible(TRUE);
		}

		$property->setValue($instance, $value);
	}


	/**
	 * @param string $name
	 * @param \ReflectionClass|null $reflection
	 * @return \ReflectionProperty
	 * @throws \InvalidArgumentException
	 */
	protected function getProperty($name, $reflection = NULL)
	{
		if (!isset($reflection)) {
			$reflection = $this->reflection;
		}

		if ($reflection->hasProperty($name)) {
			return $reflection->getProperty($name);
		}

		$parent = $reflection->getParentClass();
		if (!($parent instanceof \ReflectionClass)) {
			throw new \InvalidArgumentException('Property "' . $name . '" not exists.');
		}

		return $this->getProperty($name, $parent);
	}


	/**
	 * @param string $name
	 * @param mixed $value
	 * @param object $instance
	 * @return array [name, value]
	 * @throws \InvalidArgumentException
	 */
	protected function nameIsArray($name, $value, $instance)
	{
		list($name, $keys) = $this->parserName($name);

		$originValue = $this->getValue($name, $instance);

		if (!is_array($originValue)) {
			throw new \InvalidArgumentException('Property "' . $name . '" is not array.');
		}

		foreach ($keys as $key) {
			if ($key === '') {
				$originValue[] = $value;
			} else {
				$originValue[$key] = $value;
			}
		}

		$value = $originValue;

		return array($name, $value);
	}


	/**
	 * @param string $name
	 * @return array [name, keys]
	 */
	protected function parserName($name)
	{
		$portion = strstr($name, '[');
		$name = strstr($name, '[', TRUE);

		$portion = trim($portion, '[] ');
		$keys = explode(',', $portion);

		return array($name, $keys);
	}
}
