<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace R2Boot;

use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module {

	public function onBootstrap(MvcEvent $e) {
		$sm = $e->getApplication()->getServiceManager();
		$em = $e->getApplication()->getEventManager();

		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($em);

		$config = $sm->get('config');
		$phpSettings = $config['php_settings'];

		if ($phpSettings) {
			foreach ($phpSettings as $key => $value) {
				ini_set($key, $value);
			}
		}
/*
$listener = $sm->get('R2AuthHeader\Listener\ApiAuthenticationListener');
$em->getSharedManager()->attach('R2Base\Controller\CitiesRestController', 'dispatch', $listener);*/

	}

	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}

	public function getServiceConfig() {

		return array(
			'factories' => array(
				'R2Boot\Mail\Transport' => function ($sm) {
					$config = $sm->get('Config');

					$transport = new SmtpTransport;
					$options = new SmtpOptions($config['mail']);
					$transport->setOptions($options);

					return $transport;
				},
/*				'R2AuthHeader\Authentication\Adapter\HeaderAuthentication' => 'R2AuthHeader\Factory\AuthenticationAdapterFactory',
'R2AuthHeader\Listener\ApiAuthenticationListener' => 'R2AuthHeader\Factory\AuthenticationListenerFactory',*/
			),
		);

	}
}
