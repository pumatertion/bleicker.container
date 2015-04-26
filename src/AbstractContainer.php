<?php

namespace Bleicker\Container;

/**
 * Class AbstractContainer
 *
 * @package Bleicker\Container
 */
abstract class AbstractContainer {

	protected static $storage = [];

	/**
	 * @param string $alias
	 * @return mixed
	 */
	public static function get($alias) {
		if (static::has($alias)) {
			return static::$storage[$alias];
		}
	}

	/**
	 * @param string $alias
	 * @param mixed $data
	 * @return static
	 */
	public static function add($alias, $data) {
		static::$storage[$alias] = $data;
		return new static;
	}

	/**
	 * @param string $alias
	 * @return static
	 */
	public static function remove($alias) {
		if (static::has($alias)) {
			unset(static::$storage[$alias]);
		}
		return new static;
	}

	/**
	 * @param string $alias
	 * @return boolean
	 */
	public static function has($alias) {
		return array_key_exists($alias, static::$storage);
	}

	/**
	 * @return static
	 */
	public static function prune(){
		static::$storage = [];
		return new static;
	}

	/**
	 * @return array
	 */
	public static function storage() {
		return static::$storage;
	}
}
