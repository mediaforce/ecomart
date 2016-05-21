<?php

namespace R2Base\Enum;

use R2Base\Type\DocumentTypeInterface;
use R2Base\Type\EnumType;

class LegalDocumentType extends EnumType implements DocumentTypeInterface {
	protected static $val;

	public static function getFields() {

		// static::$msgError = 'Este valor `' . static::$val . '` não é um valor para tipo de documento valido!';

		return array("CNPJ");
	}

}