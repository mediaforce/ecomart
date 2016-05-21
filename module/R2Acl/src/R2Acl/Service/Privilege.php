<?php

namespace R2Acl\Service;

use Doctrine\ORM\EntityManager;
use R2Base\Service\AbstractService;

class Privilege extends AbstractService {
	public function __construct(\Doctrine\ORM\EntityManager $em) {
		parent::__construct($em);
		$this->entity = "R2Acl\Entity\Privilege";
	}

	public function insert(array $data) {
		$entity = new $this->entity($data);

		$role = $this->em->getReference("R2Acl\Entity\Role", $data['role']);
		$entity->setRole($role); // Injetando entidade carregada

		$resource = $this->em->getReference("R2Acl\Entity\Resource", $data['resource']);
		$entity->setResource($resource); // Injetando entidade carregada

		$this->em->persist($entity);
		$this->em->flush();
		return $entity;
	}

	public function update(array $data) {
		$entity = $this->em->getReference($this->entity, $data['id']);
		(new Hydrator\ClassMethods())->hydrate($data, $entity);

		$role = $this->em->getReference("R2Acl\Entity\Role", $data['role']);
		$entity->setRole($role); // Injetando entidade carregada

		$resource = $this->em->getReference("R2Acl\Entity\Resource", $data['resource']);
		$entity->setResource($resource); // Injetando entidade carregada

		$this->em->persist($entity);
		$this->em->flush();
		return $entity;
	}

}
