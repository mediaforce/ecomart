<?php
namespace R2Erp\Enum;

use R2Base\Type\EnumType;

class OriginSale extends EnumType {
	protected static $val;

	public static function getFields() {
		return array(
			"E-COMMERCE", // online
			"RETAIL", // físico varejo
			"RENTAL", // alugado
			"OUTLET", // venda por fora/reservado que veio do estoque para venda (internet - sistema de reserva)
		);
	}
}