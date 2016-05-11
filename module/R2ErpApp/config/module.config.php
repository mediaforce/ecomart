<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace R2ErpApp;

if (getenv('APPLICATION_ENV') === 'production') {
	defined('BUILD_PATH')
	|| define('BUILD_PATH', '../');
	defined('BUILD_PATH_VIEW')
	|| define('BUILD_PATH_VIEW', '/../../build/module/R2ErpApp');
} else {
	defined('BUILD_PATH')
	|| define('BUILD_PATH', '');
	defined('BUILD_PATH_VIEW')
	|| define('BUILD_PATH_VIEW', '');
}

return array(
	'router' => array(
		'routes' => array(
			'r2-erp-app-index' => array(
				'type' => 'hostname',
				'options' => array(
					'route' => ':5th.[:4th.]:3rd.:2nd.:1st',
					'constraints' => array(
						'5th' => 'erp',
						'4th' => 'dev',
						'3rd' => 'r2managed',
						'2nd' => 'com',
						'1st' => 'br',
					),
				),
				'child_routes' => array(
					'index' => array(
						'type' => 'Zend\Mvc\Router\Http\Literal',
						'options' => array(
							'route' => '/',
							'defaults' => array(
								'controller' => 'R2ErpApp\Controller\Index',
								'action' => 'index',
							),
						),
						'may_terminate' => true,
						'child_routes' => array(
							'users' => array(
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array(
									'route' => 'usuarios',
								),
								'may_terminate' => true,
								'child_routes' => array(
									'login' => array(
										'type' => 'Zend\Mvc\Router\Http\Literal',
										'options' => array(
											'route' => '/novo',
										),
									),
								),
							),
						),
					),
				),
			),
		),
	),

	'controllers' => array(
		'invokables' => array(
			'R2ErpApp\Controller\Index' => Controller\IndexController::class,
		),
	),
	'view_manager' => array(
		'template_map' => array(
			'r2erpapp/layout' => __DIR__ . '/..' . BUILD_PATH_VIEW . '/view/layout/layout.phtml',
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
