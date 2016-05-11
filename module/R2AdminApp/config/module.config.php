<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace R2AdminApp;

if (getenv('APPLICATION_ENV') === 'production') {
	defined('BUILD_PATH')
	|| define('BUILD_PATH', '../');
	defined('BUILD_PATH_VIEW')
	|| define('BUILD_PATH_VIEW', '/../../build/module/R2AdminApp');
} else {
	defined('BUILD_PATH')
	|| define('BUILD_PATH', '');
	defined('BUILD_PATH_VIEW')
	|| define('BUILD_PATH_VIEW', '');
}

return array(
	'router' => array(
		'routes' => array(
			'r2-admin-app-index' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route' => '/admin',
					'defaults' => array(
						'controller' => 'R2AdminApp\Controller\Index',
						'action' => 'index',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'fabricantes' => array(
						'type' => 'Zend\Mvc\Router\Http\Literal',
						'options' => array(
							'route' => 'fabricantes/',
						),
						'may_terminate' => true,
						'child_routes' => array(
							'login' => array(
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array(
									'route' => 'criar/',
								),
							),
						),
					),
					'estoque' => array(
						'type' => 'Zend\Mvc\Router\Http\Literal',
						'options' => array(
							'route' => 'estoque/',
						),
						'may_terminate' => true,
					),
				),
			),
		),
	),

	'view_manager' => array(
		'template_map' => array(
			'r2adminapp/layout' => __DIR__ . '/..' . BUILD_PATH_VIEW . '/view/layout/layout.phtml',
		),
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
