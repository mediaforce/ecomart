<?php
namespace R2AuthHeader\Factory;

use R2AuthHeader\Authentication\Adapter\HeaderAuthentication;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthenticationAdapterFactory implements FactoryInterface {
	public function createService(ServiceLocatorInterface $sl) {
		$request = $sl->get('Request');
		$respository = $sl->get('R2User\Entity\Repository\User');

		$adapter = new HeaderAuthentication($request, $repository);
		return $adapter;
	}
}