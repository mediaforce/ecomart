<?php

namespace R2Acl\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class Role extends EntityRepository {

	public function fetchParent() {
		$entities = $this->findAll();
		$array = array();

		foreach ($entities as $entity) {
			$array[$entity->getId()] = $entity->getName();
		}

		return $array;
	}

	public function findArray() {
		$roles = $this->findAll();
		$a = array();
		foreach ($roles as $role) {
			$a[$role->getId()]['id'] = $role->getId();
			$a[$role->getId()]['name'] = $role->getName();
		}

		return $a;
	}

}
