<?php

namespace R2Base\Enum;

use R2Base\Type\EnumType;

class CompanyType extends EnumType {
	protected static $val;

	public static function getFields() {

		static::$msgError = 'Este valor `' . static::$val . '` não é um valor para tipo de CompanyType valido!';

		return array(
			"MATRIX",
			"BRANCH",
			"MANUFACTURER",
			"SHIPPER",
			"SUPPLIER",
			"CUSTOMER",
		);
	}

}