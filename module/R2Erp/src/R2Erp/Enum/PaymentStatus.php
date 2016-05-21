<?php
namespace R2Erp\Enum;

use R2Base\Type\EnumType;

class PaymentStatus extends EnumType {
	protected static $val;

	public static function getFields() {
		return array(
			'Criada',
			'Aguardando pagamento',
    		'Em análise',
    		'Paga',
    		'Disponível',
    		'Em disputa',
    		'Devolvida',
    		'Cancelada',
    		'SELLER_CHARGEBACK',
            'Contestada',
            'Transação Criada',
            'Transação em Andamento',
            'Transação Autenticada',
            'Transação não Autenticada',
            'Transação Autorizada',
            'Transação não Autorizada',
            'Transação Capturada',
            'Transação Cancelada',
            'Transação em Autenticação',
            'Transação em Cancelamento',
		);
	}
}