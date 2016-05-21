<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace R2Boot;

return array(

	'service_manager' => array(
		'abstract_factories' => array(
			'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
			'Zend\Log\LoggerAbstractServiceFactory',
		),
		/*'factories' => array(
	'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
	),*/
	),
/*	'translator' => array(
'locale' => 'en_US',
'translation_file_patterns' => array(
array(
'type' => 'gettext',
'base_dir' => __DIR__ . '/../language',
'pattern' => '%s.mo',
),
),
),*/
	'view_manager' => array(
		'display_not_found_reason' => true,
		'display_exceptions' => true,
		'doctype' => 'HTML5',
		'not_found_template' => 'error/404',
		'exception_template' => 'error/index',
		'template_map' => array(
			'error/404' => __DIR__ . '/..' . BUILD_PATH_VIEW . '/view/error/404.phtml',
			'error/index' => __DIR__ . '/..' . BUILD_PATH_VIEW . '/view/error/index.phtml',
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
