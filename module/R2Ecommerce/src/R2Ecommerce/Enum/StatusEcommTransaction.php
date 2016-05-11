<?php

namespace R2Ecommerce\Entity;

use R2Base\Type\EnumType;

class StatusEcommTransaction extends EnumType {
	protected static $val;

	public static function getFields() {

		//static::$msgError = 'Este valor `' . static::$val . '` não é um valor para tipo de telefone valido!';

		return array(
			"WAITING FOR PAYMENT CONFIRMATION",
			"PAYMENT CONFIRMED",
			"PAYMENT DECLINED",
			"WAITING FOR DELIVERY CONFIRMATION",
			"DELIVERY CONFIRMED",
			"DELIVERY DECLINED");
	}

}