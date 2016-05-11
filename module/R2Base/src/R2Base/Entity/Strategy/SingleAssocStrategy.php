<?php
namespace R2Base\Entity\Strategy;

use DoctrineModule\Stdlib\Hydrator\Strategy\AllowRemoveByValue;

class SingleAssocStrategy extends AllowRemoveByValue {
	public function extract($value) {
		if ($value instanceof \Doctrine\Common\Persistence\Proxy) {
			$return = $value->toArray();
			return $return;
		}

		return $value;
	}
}