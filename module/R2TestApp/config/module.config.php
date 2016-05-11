<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace R2TestApp;

return array(
	'router' => array(
		'routes' => array(
			'r2-admin-app-index' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route' => '/teste',
					'defaults' => array(
						'controller' => 'R2TestApp\Controller\Index',
						'action' => 'index',
					),
				),
				'may_terminate' => true,
			),
			'r2-re-register-password' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route' => '/teste',
					'defaults' => array(
						'controller' => 'R2TestApp\Controller\Index',
						'action' => 'index',
					),
				),
				'may_terminate' => true,
			),
		),
	),

	'view_manager' => array(
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
	// Placeholder for console routes
	'console' => array(
		'router' => array(
			'routes' => array(
			),
		),
	),
);
