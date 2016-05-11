<?php
namespace R2Erp\Enum;

use R2Base\Type\EnumType;

class StoreStatus extends EnumType {
	protected static $val;

	public static function getFields() {

		// static::$msgError = 'Este valor `' . static::$val . '` não é um valor para bandeira de cartão!';

		return array(
			"PEDIDO", // pedido
			"VENDA", // venda
			"MANTER", // serviço
		);
	}
}