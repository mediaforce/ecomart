<?php
namespace R2Tracker;

return array(
	'controllers' => array(
		'invokables' => array(
			'R2Tracker\Controller\UserTrackerRest' => 'R2Tracker\Controller\UserTrackerRestController',
		),
	),

	'router' => array(
		'routes' => array(
			'r2base-api-user-tracker-rest' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/tracker/usertracker[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Tracker\Controller\UserTrackerRest',
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
);