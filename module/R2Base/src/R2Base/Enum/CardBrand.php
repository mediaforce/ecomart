<?php

namespace R2Base\Enum;

use R2Base\Type\EnumType;

class CardBrand extends EnumType {
	protected static $val;

	public static function getFields() {

		// static::$msgError = 'Este valor `' . static::$val . '` não é um valor para bandeira de cartão!';

		return array(
			"VISA",
			"MASTERCARD",
			"AMERICACAN EXPRESS",
			"ELOO",
			"DINNERS CLUB",
			"DISCOVER",
			"JCB",
			"AURA",
			"HIPERCARD",
			"HIPER",
			"CABAL CRéDITO",
			"SOROCRED",
			"SICREDI",
			"COOPER CARD*",
			"AVISTA*",
			"BANDEIRA MAIS!",
			"UNIONPAY INTERNACIONAL (UPI)",
			"BNDES");
	}

}