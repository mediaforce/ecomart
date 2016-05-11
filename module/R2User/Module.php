<?php

namespace R2User;

use R2User\Auth\Adapter as AuthAdapter;

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
/*
public function init(ModuleManager $moduleManager) {
$sharedEvents = $moduleManager->getEventManager()->getSharedManager();

$sharedEvents->attach("Zend\Mvc\Controller\AbstractRestfulController",
MvcEvent::EVENT_DISPATCH,
array($this, 'headerAuth'), 100);
}

public function headerAuth($e) {
$e->getResponse()->setStatusCode(401);
$e->stopPropagation();
return;

}
 */
	public function getServiceConfig() {

		return array(
			'factories' => array(
				'R2User\Service\User' => function ($sm) {
					return new Service\User(
						$sm->get('Doctrine\ORM\EntityManager'),
						$sm->get('R2Boot\Mail\Transport'),
						$sm->get('View'));
				},
				'R2User\Auth\Adapter' => function ($sm) {
					return new AuthAdapter($sm->get('Doctrine\ORM\EntityManager'));
				},
			),

		);

	}

	public function getControllerConfig() {
		return array(
			'factories' => array(
				'R2User\Controller\UsersRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					$service = $locator->get('R2User\Service\User');

					$controller = new Controller\UsersRestController($em, $service);

					return $controller;
				},
				'R2User\Controller\CheckUniqueUserRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');

					$controller = new Controller\CheckUniqueUserRestController($em);

					return $controller;
				},
				'R2User\Controller\AuthRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$adapter = $locator->get('R2User\Auth\Adapter');

					$controller = new Controller\AuthRestController($adapter);

					return $controller;
				},
				'R2User\Controller\ForgotPasswordRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					$transport = $locator->get('R2Base\Mail\Transport');
					$view = $locator->get('View');

					$controller = new Controller\ForgotPasswordRestController($em, $transport, $view);

					return $controller;
				},
			),
		);
	}

}
