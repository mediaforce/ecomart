<?php

namespace R2Base\Enum;

use R2Base\Type\EnumType;

class MobileMNO extends EnumType {
	protected static $val;

	public static function getFields() {

		//static::$msgError = 'Este valor `' . static::$val . '` não é um valor para operadora de telefone valido!';

		return array("VIVO", "TIM", "OI", "CLARO", "OUTRO");
	}

}