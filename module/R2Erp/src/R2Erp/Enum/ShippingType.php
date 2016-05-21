<?php
namespace R2Erp\Enum;

use R2Base\Type\EnumType;

class ShippingType extends EnumType {
	protected static $val;

	public static function getFields() {
		return array(
			"ISSUER",
			"RECEIVER",
			"PAC",
			"SEDEX",
		);
	}
}