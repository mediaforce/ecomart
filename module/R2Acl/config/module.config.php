<?php

namespace R2Acl;

return array(
	'controllers' => array(
		'invokables' => array(
			'R2Acl\Controller\RolesRest' => 'R2Acl\Controller\RolesRestController',
		),
	),

	'router' => array(
		'routes' => array(
			'r2acl-roles-rest' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/acl/roles[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Acl\Controller\RolesRest',
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
		'SONUser_fixture' => __DIR__ . '/../src/' . __NAMESPACE__ . '/Fixture',
	),
);