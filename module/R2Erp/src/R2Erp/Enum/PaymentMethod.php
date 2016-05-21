<?php
namespace R2Erp\Enum;

use R2Base\Type\EnumType;

class PaymentMethod extends EnumType {
	protected static $val;

	public static function getFields() {
		return array(
			'CREDITO À VISTA',
    		'PARCELADO LOJA',
    		'PARCELADO PAGSEGURO',
    		'PARCELADO ADM',
    		'BOLETO',
    		'TRANSFERENCIA ONLINE',
    		'OI PAGGO',
    		'BALANÇO PAGSEGURO',
    		'DEPÓSITO',
		);
	}
}