<?php

namespace R2Base\Enum;

use R2Base\Type\EnumType;

class Gender extends EnumType {
	protected static $val;

	public static function getFields() {

		return array("MALE", "FEMALE");
	}

}