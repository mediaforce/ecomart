<?php

namespace R2Base\Enum;

use R2Base\Type\EnumType;

class TelephoneType extends EnumType {
	protected static $val;

	public static function getFields() {

		//static::$msgError = 'Este valor `' . static::$val . '` não é um valor para tipo de telefone valido!';

		return array("RESIDENCIAL", "CELULAR");
	}

}