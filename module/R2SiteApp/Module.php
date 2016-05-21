<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace R2SiteApp;

use Zend\ModuleManager\ModuleManager;

use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

class Module {
	public function init(ModuleManager $mm) {
		$mm->getEventManager()->getSharedManager()->attach(__NAMESPACE__,
			'dispatch', function ($e) {
				$e->getTarget()->layout('r2siteapp/layout');
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
				'R2SiteApp\Controller\Index' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');

					$controller = new Controller\IndexController($em);

					return $controller;
				}
			)
		);

	}
}
