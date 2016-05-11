<?php

namespace R2Tracker;

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
				'R2Tracker\Service\UserTracker' => function ($sm) {
					return new Service\UserTracker(
						$sm->get('Doctrine\ORM\EntityManager'),
						$sm->get('R2App\Mail\Transport'),
						$sm->get('View'));
				},
			),

		);

	}

}
