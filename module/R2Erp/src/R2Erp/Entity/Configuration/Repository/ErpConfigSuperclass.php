<?php

namespace R2Erp\Entity\Configuration\Repository;

use Doctrine\ORM\EntityRepository;

class ErpConfigSuperclass extends EntityRepository {

	public function findArray() {

		$data = $this->findAll();
		$a = array();
		foreach ($data as $entity) {
			$className = get_class($entity);

			if ($className == 'R2Erp\Entity\Configuration\Type\IntegerConfig') {
				$a['IntegerConfig'][$entity->getId()] = array(
					'name' => $entity->getName(),
					'value' => $entity->getValue(),
				);
			} elseif ($className == 'R2Erp\Entity\Configuration\Type\ArrayConfig') {
				$a['ArrayConfig'][$entity->getId()] = array(
					'name' => $entity->getName(),
					'value' => $entity->getValue(),
				);
			} elseif ($className == 'R2Erp\Entity\Configuration\Type\BooleanConfig') {
				$a['BooleanConfig'][$entity->getId()] = array(
					'name' => $entity->getName(),
					'value' => $entity->getValue(),
				);
			} elseif ($className == 'R2Erp\Entity\Configuration\Type\FloatConfig') {
				$a['FloatConfig'][$entity->getId()] = array(
					'name' => $entity->getName(),
					'value' => $entity->getValue(),
				);
			} elseif ($className == 'R2Erp\Entity\Configuration\Type\StringConfig') {
				$a['StringConfig'][$entity->getId()] = array(
					'name' => $entity->getName(),
					'value' => $entity->getValue(),
				);
			} elseif ($className == 'R2Erp\Entity\Configuration\Type\TextConfig') {
				$a['TextConfig'][$entity->getId()] = array(
					'name' => $entity->getName(),
					'value' => $entity->getValue(),
				);
			}
		}

		return $a;
	}

}
