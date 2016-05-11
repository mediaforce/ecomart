<?php

namespace R2Base;

return array(

	'router' => array(
		'routes' => array(
			'r2base-getenums-rest' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/base/getenums[/:enum]',
					'constraints' => array(
						'enum' => '[A-Za-z_]+',
					),
					'defaults' => array(
						'controller' => 'R2Base\Controller\GetEnumsRest',
					),
				),
			),
			'r2base-calc-frete-rest' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/base/calcfrete[/:enum]',
					'constraints' => array(
						'enum' => '[A-Za-z_]+',
					),
					'defaults' => array(
						'controller' => 'R2Base\Controller\CalcularFreteRest',
					),
				),
			),
			'r2base-companies-rest' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/base/companies[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Base\Controller\CompaniesRest',
					),
				),
			),
			'r2base-states-rest' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/base/states[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Base\Controller\StatesRest',
					),
				),
			),
			'r2base-cities-rest' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/base/cities[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Base\Controller\CitiesRest',
					),
				),
			),
			'r2base-images-rest' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/base/images[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Base\Controller\ImagesRest',
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