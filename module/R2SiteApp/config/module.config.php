<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace R2SiteApp;

if (getenv('APPLICATION_ENV') === 'production') {
	defined('BUILD_PATH')
	|| define('BUILD_PATH', '../');
	defined('BUILD_PATH_VIEW')
	|| define('BUILD_PATH_VIEW', '/../../build/module/R2SiteApp');
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
			'r2-site-app-index' => array(
				'type' => 'hostname',
				'options' => array(
					'route' => '[:5th.][:4th.]:3rd.:2nd.:1st',
					'constraints' => array(
						'5th' => 'www',
						'4th' => 'dev',
						'3rd' => 'ecomart',
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
								'controller' => 'R2SiteApp\Controller\Index',
								'action' => 'index',
							),
						),
						'may_terminate' => true,
						'child_routes' => array(
							'users' => array(
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array(
									'route' => 'usuario',
								),
								'may_terminate' => false,
								'child_routes' => array(
									'registro' => array(
							             'type' => 'segment',
							             'options' => array(
							                 'route'    => '/registro/:part',
							                 'constraints' => array(
							                     'part' => '[a-zA-Z][a-zA-Z0-9_-]*'
							                 )
							             ),
							        ),
									'pages' => array(
										'type' => 'segment',
							             'options' => array(
							                 'route'    => '/pagina/:page',
							                 'constraints' => array(
							                     'page' => '[a-zA-Z][a-zA-Z0-9_-]*'
							                 )
							             ),
									)
								),
							),
							'produto-detalhe' => array(
					             'type' => 'segment',
					             'options' => array(
					                 'route'    => 'produto/:id/:slug',
					                 'constraints' => array(
					                     'id' => '[0-9]+'
					                 )
					             ),
					         ),
							'procurar-produtos' => array(
					             'type' => 'segment',
					             'options' => array(
					                 'route'    => 'procurar-produto/:search',
					             ),
					         ),
							're-register-password' => array(
					             'type' => 'segment',
					             'options' => array(
					                 'route'    => 'recadastrar-senha/:key',
					             ),
					         ),
					         'paginas' => array(
					             'type' => 'segment',
					             'options' => array(
					                 'route'    => 'pagina/:single/',
					                 'constraints' => array(
					                     'single' => '[a-zA-Z][a-zA-Z0-9_-]*'
					                 )
					             ),
					         ),
					         'departamentos' => array(
					             'type' => 'segment',
					             'options' => array(
					                 'route'    => 'departamentos/:dept/',
					                 'constraints' => array(
					                     'dept' => '[a-zA-Z][a-zA-Z0-9_-]*'
					                 )
					             ),
					         ),
							'checkout' => array(
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array(
									'route' => 'meu-carrinho',
								),
								'may_terminate' => true,
							),
							'combos' => array(
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array(
									'route' => 'combos',
								),
								'may_terminate' => true,
							),
							'combo-detalhe' => array(
					             'type' => 'segment',
					             'options' => array(
					                 'route'    => 'combo/:id/:slug',
					                 'constraints' => array(
					                     'id' => '[0-9]+'
					                 )
					             ),
					         ),
							'pagseguro-compra-finalizada' => array(
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array(
									'route' => 'pagseguro/compra-finalizada',
								),
								'may_terminate' => true,
							),
						),
					),
				),
			),
		),
	),


	'view_manager' => array(
		'template_map' => array(
			'r2siteapp/layout' => __DIR__ . '/..' . BUILD_PATH_VIEW . '/view/layout/layout.phtml',
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
