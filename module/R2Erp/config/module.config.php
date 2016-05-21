<?php
namespace R2Erp;

return array(
	'router' => array(
		'routes' => array(
			'r2erp-manufacturer-manufacturers' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/erp/manufacturers[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Erp\Controller\ManufacturersRest',
					),
				),
			),
			'r2erp-product-products' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/erp/products[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Erp\Controller\ProductsRest',
					),
				),
			),
			'r2erp-product-combo-products' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/erp/comboproducts[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Erp\Controller\ComboProductsRest',
					),
				),
			),
			'r2erp-product-departments' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/erp/product/departments[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Erp\Controller\DepartmentsRest',
					),
				),
			),
			'r2erp-product-categories' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/erp/product/categories[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Erp\Controller\CategoriesRest',
					),
				),
			),
			'r2erp-product-features' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/erp/product/features[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Erp\Controller\FeaturesRest',
					),
				),
			),
			'r2erp-product-feature-groups' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/erp/product/featuresgroups[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Erp\Controller\FeatureGroupsRest',
					),
				),
			),
			'r2erp-product-discount-coupons' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/erp/product/discountcoupons[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Erp\Controller\DiscountCouponRest',
					),
				),
			),
			'r2erp-order-stores' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/erp/order/stores[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Erp\Controller\StoresRest',
					),
				),
			),
			'r2erp-order-combo-stores' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/erp/order/combostores[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Erp\Controller\ComboStoresRest',
					),
				),
			),
			'r2erp-order-sales' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/erp/order/sales[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Erp\Controller\SalesRest',
					),
				),
			),
			'r2erp-order-sale-orders' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/erp/order/sale-orders[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Erp\Controller\OrderSaleOrdersRest',
					),
				),
			),
			'r2erp-customer-customers' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/erp/customers[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Erp\Controller\CustomersRest',
					),
				),
			),
			'r2erp-checkout-pagseguro' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/erp/checkout/pagseguro[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Erp\Controller\PagseguroCheckoutRest',
					),
				),
			),
			'r2erp-checkout-boleto-bradesco' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/erp/checkout/boleto-bradesco[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Erp\Controller\BoletoBradescoCheckoutRest',
					),
				),
			),
			'r2erp-checkout-cielo' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/erp/checkout/cielo[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Erp\Controller\CieloRest',
					),
				),
			),
			'r2erp-notification-cielo' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/erp/notification/cielo[/:id]',
					'constraints' => array(
						'id' => '[a-zA-Z0-9_-]+',
					),
					'defaults' => array(
						'controller' => 'R2Erp\Controller\CieloNotificationRest',
					),
				),
			),
			'r2erp-notification-pagseguro' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/erp/notification/pagseguro[/:id]',
					'constraints' => array(
						'id' => '[a-zA-Z0-9_-]+',
					),
					'defaults' => array(
						'controller' => 'R2Erp\Controller\PagseguroNotificationRest',
					),
				),
			),
			'r2erp-checkout-test-return' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/api/erp/checkout/testreturn[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'R2Erp\Controller\TestReturnRest',
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