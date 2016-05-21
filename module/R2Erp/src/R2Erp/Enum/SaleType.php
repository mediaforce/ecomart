<?php
namespace R2Erp\Enum;

use R2Base\Type\EnumType;

class SaleType extends EnumType {
	protected static $val;

	public static function getFields() {
		return array(
			"ECOMMERCE",
			"RENTAL",
		);
	}
}