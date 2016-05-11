<?php
namespace R2Erp\Enum;

use R2Base\Type\EnumType;

class ExpenseType extends EnumType {
	protected static $val;

	public static function getFields() {
		return array(
			"DEPRECIATION", // RESERVA...
			"AMORTIZATION", // RESERVA...
			"EXHAUSTION", // RESERVA...
			"EXPENSE",
		);
	}
}