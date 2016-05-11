<?php

namespace R2Acl;

class Module {

	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig() {
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__=> __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}

	public function getServiceConfig() {

		return array(
			'factories' => array(

				'R2Acl\Service\Role' => function ($sm) {
					return new Service\Role($sm->get('Doctrine\ORM\Entitymanager'));
				},
				'R2Acl\Service\Resource' => function ($sm) {
					return new Service\Resource($sm->get('Doctrine\ORM\Entitymanager'));
				},
				'R2Acl\Service\Privilege' => function ($sm) {
					return new Service\Privilege($sm->get('Doctrine\ORM\Entitymanager'));
				},

				'R2Acl\Permissions\Acl' => function ($sm) {
					$em = $sm->get('Doctrine\ORM\EntityManager');

					$repoRole = $em->getRepository("R2Acl\Entity\Role");
					$roles = $repoRole->findAll();

					$repoResource = $em->getRepository("R2Acl\Entity\Resource");
					$resources = $repoResource->findAll();

					$repoPrivilege = $em->getRepository("R2Acl\Entity\Privilege");
					$privileges = $repoPrivilege->findAll();

					return new Permissions\Acl($roles, $resources, $privileges);
				},
			),
		);

	}

}
