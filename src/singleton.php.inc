<?php
namespace ws\rest;

trait Singleton {
	private static $instance;

	public static function getInstance() {
		if (self::$instance === NULL) {
			$class = __CLASS__;
			$instance = new $class;
		}

		return $instance;
	}
}
?>