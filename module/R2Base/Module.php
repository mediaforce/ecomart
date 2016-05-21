<?php

namespace R2Base;

use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

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
				'R2Base\Service\Image' => function ($sm) {
					return new Service\Image(
						$sm->get('Doctrine\ORM\EntityManager'));
				},
				'R2Base\Mail\Transport' => function ($sm) {
					$config = $sm->get('Config');

					$transport = new SmtpTransport();
					$options = new SmtpOptions($config['mail']);
					$transport->setOptions($options);

					return $transport;
					
				}
			),

		);
	}

	public function getControllerConfig() {
		return array(
			'factories' => array(
				'R2Base\Controller\CompaniesRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');

					$controller = new Controller\CompaniesRestController($em);

					return $controller;
				},
				'R2Base\Controller\StatesRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					$service = $locator->get('R2Erp\Service\Product');

					$controller = new Controller\StatesRestController($em);

					return $controller;
				},
				'R2Base\Controller\CitiesRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');

					$controller = new Controller\CitiesRestController($em);

					return $controller;
				},
				'R2Base\Controller\ImagesRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					$service = $locator->get('R2Base\Service\Image');

					$controller = new Controller\ImagesRestController($em, $sm);

					return $controller;
				},
				'R2Base\Controller\GetEnumsRest' => function ($sm) {
					$controller = new Controller\GetEnumsRestController();

					return $controller;
				},
				'R2Base\Controller\CalcularFreteRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					
					$controller = new Controller\CalcularFreteRestController($em);

					return $controller;
				},
			),
		);
	}

}