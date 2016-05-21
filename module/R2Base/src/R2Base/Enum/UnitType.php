<?php

namespace R2Crm\Enum;

use R2Base\Type\EnumType;

class UnitType extends EnumType {
	protected static $val;

	public static function getFields() {

		// static::$msgError = 'Este valor `' . static::$val . '` não é um valor para tipo de telefone valido!';

		return array(
			"UNIDADE",
			"PESO",
			"VOLUME",
			"ÁREA",
			"TEMPO",
		);
	}

}