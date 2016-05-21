<?php

namespace R2User\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use R2Base\Entity\Address;
use R2Base\Entity\Document;
use R2Base\Entity\Email;
use R2Base\Entity\Person;
use R2Base\Entity\SocialNetwork;
use R2Base\Entity\Telephone;
use R2Base\Enum\Gender;
use R2Base\Enum\MobileMNO;
use R2Base\Enum\PhysicalDocumentType;
use R2Base\Enum\TelephoneType;
use R2Base\Mail\Mail;
use R2Base\Service\AbstractService;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Stdlib\Hydrator;

class User extends AbstractService {
	protected $transport;
	protected $view;

	public function __construct(EntityManager $em, SmtpTransport $transport, $view) {
		parent::__construct($em);

		$this->entity = "R2User\Entity\User";
		$this->transport = $transport;
		$this->view = $view;
	}

	public function update(array $data) {
		$entity = $this->em->getReference($this->entity, $data['id']);
		
		foreach($entity->getPerson()->getDocuments() as $document) {
			$this->em->remove($document);
			$entity->getPerson()->getDocuments()->removeElement($document);
		}

		foreach($entity->getPerson()->getAddresses() as $address) {
			$this->em->remove($address);
			$entity->getPerson()->getAddresses()->removeElement($address);
		}

		foreach($entity->getPerson()->getTelephones() as $telephone) {
			$this->em->remove($telephone);
			$entity->getPerson()->getTelephones()->removeElement($telephone);
		}

		$this->em->flush();

		(new Hydrator\ClassMethods())->hydrate($data, $entity);

		$this->em->persist($entity);
		$this->em->flush();

		return $entity;
	}

}