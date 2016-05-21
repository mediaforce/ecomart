<?php
namespace R2Erp\Enum;

use R2Base\Type\EnumType;

class DiscrepancyStatus extends EnumType {
	protected static $val;

	public static function getFields() {
		return array(
			"DEFECT",
			"LOST",
			"STOLEN",
			"BROKE",
		);
	}
}