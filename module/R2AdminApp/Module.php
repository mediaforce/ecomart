<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace R2AdminApp;

use Zend\ModuleManager\ModuleManager;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

class Module {
	public function init(ModuleManager $mm) {
		$mm->getEventManager()->getSharedManager()->attach(__NAMESPACE__,
			'dispatch', function ($e) {
				$e->getTarget()->layout('r2adminapp/layout');
			});
	}

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
				'R2AdminApp\Controller\Index' => function ($sm) {
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
