<?php

namespace R2AuthHeader\Factory;

use MyApp\Api\Listener\ApiAuthenticationListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthenticationListenerFactory implements FactoryInterface {
	public function createService(ServiceLocatorInterface $sl) {
		$name = 'R2AuthHeader\Authentication\Adapter\HeaderAuthentication';
		$adapter = $sl->get($name);

		$listener = new ApiAuthenticationListener($adapter);
		return $listener;
	}
}