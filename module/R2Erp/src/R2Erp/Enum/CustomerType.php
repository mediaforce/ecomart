<?php
namespace R2Erp\Enum;

use R2Base\Type\EnumType;

class CustomerType extends EnumType {
	protected static $val;

	public static function getFields() {
		return array(
			"PHYSICAL",
			"LEGAL",
		);
	}
}