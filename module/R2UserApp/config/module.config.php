<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace R2AppSite;

if (getenv('APPLICATION_ENV') === 'production') {
	defined('BUILD_PATH')
	|| define('BUILD_PATH', '../');
	defined('BUILD_PATH_VIEW')
	|| define('BUILD_PATH_VIEW', '/../../build/module/R2AppSite');
} else {
	defined('BUILD_PATH')
	|| define('BUILD_PATH', '');
	defined('BUILD_PATH_VIEW')
	|| define('BUILD_PATH_VIEW', '');
}

// if (file_exists('../build/module/R2AppSite/view/layout/layout.phtml')) echo 'ok';
// echo __DIR__; die;

return array(
	'router' => array(
		'routes' => array(
			'home' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route' => '/',
					'defaults' => array(
						'controller' => 'R2AppSite\Controller\Index',
						'action' => 'index',
					),
				),
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'R2AppSite\Controller\Index' => Controller\IndexController::class,
		),
	),
	'view_manager' => array(
		'display_not_found_reason' => true,
		'display_exceptions' => true,
		'doctype' => 'HTML5',
		'not_found_template' => 'error/404',
		'exception_template' => 'error/index',
		'template_map' => array(
			'r2appsite/layout' => __DIR__ . '/..' . BUILD_PATH_VIEW . '/view/layout/layout.phtml',
			'r2appsite/index/index' => __DIR__ . '/..' . BUILD_PATH_VIEW . '/view/r2-app-site/index/index.phtml',
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
