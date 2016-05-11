<?php
namespace R2Erp\Enum;

use R2Base\Type\EnumType;

class ProductionStatus extends EnumType {
	protected static $val;

	public static function getFields() {
		return array(
			"WAITING RAW MATERIAL",
			"IN PRODUCTION",
			"FINISHED",
		);
	}
}