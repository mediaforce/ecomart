<?php

namespace R2Erp\Service\Product;

use Doctrine\ORM\EntityManager;
use R2Base\Service\AbstractService;

class Category extends AbstractService {
	protected $transport;
	protected $view;

	public function __construct(EntityManager $em) {
		parent::__construct($em);

		$this->entity = "R2Erp\Entity\Product\ProductCategory";
	}

	public function delete($id) {
		$entity = $this->em->getReference($this->entity, $id);
		$subcategories = $entity->getSubcategories();
		$entity->setSubcategories(new \Doctrine\Common\Collections\ArrayCollection());
		$this->em->persist($entity);
		foreach ($subcategories as $subcategory) {
			$this->em->remove($subcategory);
		}
		$this->em->flush();
		parent::delete($id);
	}

	// TODO FAZER FILTROS E VALIDAÇÕES!!!!!!!!!!!!!!!!!!!!

}