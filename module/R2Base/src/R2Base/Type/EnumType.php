<?php

namespace R2Base\Type;

abstract class EnumType {
	protected static $val;
	protected static $msgError;

	protected static function getFields() {
		return new static();
	}

	final function __construct($str) {

		static::$val = strtoupper($str);

		if (empty(static::$msgError)) {
			static::$msgError = "unknown type value: $str";
		}

		if (!in_array($str, $this->getFields())) {
			throw new \Exception(static::$msgError);
		}

	}

	public static function __callStatic($func, $args) {
		return new static($func);
	}

	public function value() {
		return static::$val;
	}

	public function __toString() {
		return $this->value();
	}
}