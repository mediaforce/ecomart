<?php
namespace R2Erp\Enum;

use R2Base\Type\EnumType;

class RateType extends EnumType {
	protected static $val;

	public static function getFields() {

		// static::$msgError = 'Este valor `' . static::$val . '` não é um valor para bandeira de cartão!';

		return array(
			"PERCENTAGE",
			"EXACT VALUE",
		);
	}
}