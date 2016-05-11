<?php
namespace R2Erp\Enum;

use R2Base\Type\EnumType;

class DevolutionStatus extends EnumType {
	protected static $val;

	public static function getFields() {
		return array(
			"EXCHANGED",
			"SUBSTITUTED",
			"WAITING_PROVIDER",
			"REVERSAL",
		);
	}
}