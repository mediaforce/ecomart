<?php
namespace R2User;

return array(
	'router' => array(
		'routes' => array(
			'r2user-users-rest' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/user/users[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2User\Controller\UsersRest',
					),
				),
			),
			'r2user-uniqueuser-rest' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/user/uniqueuser[/:id]',
					'constraints' => array(
						'id' => '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$',
					),
					'defaults' => array(
						'controller' => 'R2User\Controller\CheckUniqueUserRest',
					),
				),
			),
			'r2user-auth-rest' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/user/users/auth[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2User\Controller\AuthRest',
					),
				),
			),
			'r2user-forgot-password' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/user/forgot-password[/:id]',
					'constraints' => array(
						'id' => '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$',
					),
					'defaults' => array(
						'controller' => 'R2User\Controller\ForgotPasswordRest',
					),
				),
			),
		),
	),

	'view_manager' => array(
		'strategies' => array(
			'ViewJsonStrategy',
		),
	),

	'doctrine' => array(
		'driver' => array(
			__NAMESPACE__ . '_driver' => array(
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'),
			),
			'orm_default' => array(
				'drivers' => array(
					__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
				),
			),
		),

	),
	'data-fixture' => array(
		__NAMESPACE__ . '_fixture' => __DIR__ . '/../src/' . __NAMESPACE__ . '/Fixture',
	),

);
