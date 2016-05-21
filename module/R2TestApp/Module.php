<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace R2TestApp;

use Zend\ModuleManager\ModuleManager;


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

	public function getControllerConfig() {
		return array(
			'factories' => array(
				'R2TestApp\Controller\Index' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					$transport = $locator->get('R2Base\Mail\Transport');
					$view = $locator->get('View');

					$controller = new Controller\IndexController($em, $transport, $view);

					return $controller;
				}
			)
		);

	}
}
