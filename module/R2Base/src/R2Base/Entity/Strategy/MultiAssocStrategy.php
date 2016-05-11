<?php
namespace R2Base\Entity\Strategy;

use DoctrineModule\Stdlib\Hydrator\Strategy\AllowRemoveByValue;
use Doctrine\Common\Collections\ArrayCollection;

class MultiAssocStrategy extends AllowRemoveByValue {
	public function extract($value) {
		if ($value instanceof \Doctrine\ORM\PersistentCollection
			|| $value instanceof \Doctrine\Common\Collections\ArrayCollection) {
			$return = array();
			foreach ($value as $entity) {
				array_push($return, $entity->toArray());
			}
			return $return;
		}
		return $value;
	}
}