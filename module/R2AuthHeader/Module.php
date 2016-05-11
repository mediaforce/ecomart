<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace R2AuthHeader;
use Zend\Mvc\MvcEvent;

class Module {

	public function onBootstrap(MvcEvent $e) {
		$app = $e->getApplication();
		$sm = $e->getApplication()->getServiceManager();
		$em = $e->getApplication()->getEventManager();

		$listener = $sm->get('R2AuthHeader\Listener\ApiAuthenticationListener');
		$em->getSharedManager()->attach('R2User\Controller', 'dispatch', $listener);
	}

	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}

	public function getServiceConfig() {

		return array(
			'services' => array(
				'factories' => array(
					'R2AuthHeader\Authentication\Adapter\HeaderAuthentication' => 'R2AuthHeader\Factory\AuthenticationAdapterFactory',
					'R2AuthHeader\Listener\ApiAuthenticationListener' => 'R2AuthHeader\Factory\AuthenticationListenerFactory',
				),
			),
		);

	}
}
