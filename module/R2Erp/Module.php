<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 27/10/2015
 * Time: 19:24
 */

namespace R2Erp;

use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements ControllerProviderInterface, ServiceProviderInterface {
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig() {

		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__=> __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}

	public function getServiceConfig() {

		return array(
			'factories' => array(
				'R2Erp\Service\Manufacturer' => function ($sm) {
					return new Service\Manufacturer\Manufacturer(
						$sm->get('Doctrine\ORM\EntityManager'));
				},
				'R2Erp\Service\Product' => function ($sm) {
					return new Service\Product\Product(
						$sm->get('Doctrine\ORM\EntityManager'));
				},
				'R2Erp\Service\ComboProduct' => function ($sm) {
					return new Service\Product\ComboProduct(
						$sm->get('Doctrine\ORM\EntityManager'));
				},
				'R2Erp\Service\Product\Department' => function ($sm) {
					return new Service\Product\Department(
						$sm->get('Doctrine\ORM\EntityManager'));
				},
				'R2Erp\Service\Product\Category' => function ($sm) {
					return new Service\Product\Category(
						$sm->get('Doctrine\ORM\EntityManager'));
				},
				'R2Erp\Service\Product\Feature' => function ($sm) {
					return new Service\Product\Feature(
						$sm->get('Doctrine\ORM\EntityManager'));
				},
				'R2Erp\Service\Product\FeatureGroup' => function ($sm) {
					return new Service\Product\FeatureGroup(
						$sm->get('Doctrine\ORM\EntityManager'));
				},
				'R2Erp\Service\OrderStore' => function ($sm) {
					return new Service\Order\Store\Store(
						$sm->get('Doctrine\ORM\EntityManager'));
				},
				'R2Erp\Service\OrderComboStore' => function ($sm) {
					return new Service\Order\Store\ComboStore(
						$sm->get('Doctrine\ORM\EntityManager'));
				},
				'R2Erp\Service\Customer' => function ($sm) {
					return new Service\Customer\Customer(
						$sm->get('Doctrine\ORM\EntityManager'));
				},
				'R2Erp\Service\Product\DiscountCoupon' => function ($sm) {
					return new Service\Product\DiscountCoupon(
						$sm->get('Doctrine\ORM\EntityManager'));
				},
				'R2Erp\Service\SaleOrder' => function ($sm) {
					return new Service\Order\Sale\Order(
						$sm->get('Doctrine\ORM\EntityManager'));
				},
				'R2Erp\Service\Sale' => function ($sm) {
					return new Service\Order\Sale\Sale(
						$sm->get('Doctrine\ORM\EntityManager'));
				},
				'R2Erp\Service\Payment' => function ($sm) {
					return new Service\Financial\Payment(
						$sm->get('Doctrine\ORM\EntityManager'));
				},
				'R2Erp\Service\Ecommerce\EcommTransaction' => function ($sm) {
					$em = $sm->get('Doctrine\ORM\EntityManager');
					$orderSaleSrv = $sm->get('R2Erp\Service\SaleOrder');
					$saleSrv = $sm->get('R2Erp\Service\Sale');
					$paymentSrv = $sm->get('R2Erp\Service\Payment');

					return new Service\Ecommerce\EcommFlux(
						$em,
						$saleSrv,
						$orderSaleSrv,
						$paymentSrv
					);
				},
			),

		);

	}

	public function getControllerConfig() {
		return array(
			'factories' => array(
				'R2Erp\Controller\ManufacturersRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					$service = $locator->get('R2Erp\Service\Manufacturer');

					$controller = new Controller\Manufacturer\ManufacturersRestController($em, $service);

					return $controller;
				},
				'R2Erp\Controller\ProductsRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					$service = $locator->get('R2Erp\Service\Product');

					$controller = new Controller\Product\ProductsRestController($em, $service);

					return $controller;
				},
				'R2Erp\Controller\ComboProductsRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					$service = $locator->get('R2Erp\Service\ComboProduct');

					$controller = new Controller\Product\ComboProductsRestController($em, $service);

					return $controller;
				},
				'R2Erp\Controller\DepartmentsRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					$service = $locator->get('R2Erp\Service\Product\Department');

					$controller = new Controller\Product\DepartmentsRestController($em, $service);

					return $controller;
				},
				'R2Erp\Controller\CategoriesRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					$service = $locator->get('R2Erp\Service\Product\Category');

					$controller = new Controller\Product\CategoriesRestController($em, $service);

					return $controller;
				},
				'R2Erp\Controller\FeaturesRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					$service = $locator->get('R2Erp\Service\Product\Feature');

					$controller = new Controller\Product\FeaturesRestController($em, $service);

					return $controller;
				},
				'R2Erp\Controller\FeatureGroupsRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					$service = $locator->get('R2Erp\Service\Product\FeatureGroup');

					$controller = new Controller\Product\FeatureGroupsRestController($em, $service);

					return $controller;
				},
				'R2Erp\Controller\StoresRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					$service = $locator->get('R2Erp\Service\OrderStore');

					$controller = new Controller\Order\Store\StoresRestController($em, $service);

					return $controller;
				},
				'R2Erp\Controller\ComboStoresRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					$service = $locator->get('R2Erp\Service\OrderComboStore' );

					$controller = new Controller\Order\Store\ComboStoresRestController($em, $service);

					return $controller;
				},
				'R2Erp\Controller\OrderSaleOrdersRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					$service = $locator->get('R2Erp\Service\SaleOrder');
					$ecommSrv = $locator->get('R2Erp\Service\Ecommerce\EcommTransaction');

					$controller = new Controller\Order\Sale\OrdersRestController($em, $service, $ecommSrv);

					return $controller;
				},
				'R2Erp\Controller\CustomersRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					$service = $locator->get('R2Erp\Service\Customer');

					$controller = new Controller\Customer\CustomersRestController($em, $service);

					return $controller;
				},
				'R2Erp\Controller\SalesRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');

					$controller = new Controller\Order\Sale\SalesRestController($em);

					return $controller;
				},
				'R2Erp\Controller\DiscountCouponRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					$service = $locator->get('R2Erp\Service\Product\DiscountCoupon');

					$controller = new Controller\Product\DiscountCouponsRestController($em, $service);

					return $controller;
				},
				'R2Erp\Controller\PagseguroCheckoutRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					$ecommSrv = $locator->get('R2Erp\Service\Ecommerce\EcommTransaction');

					$controller = new Controller\Checkout\PagseguroRestController($em, $ecommSrv);

					return $controller;
				},
				'R2Erp\Controller\BoletoBradescoCheckoutRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					$ecommSrv = $locator->get('R2Erp\Service\Ecommerce\EcommTransaction');

					$controller = new Controller\Checkout\BoletoBradescoRestController($em, $ecommSrv);

					return $controller;
				},
				'R2Erp\Controller\CieloRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					$ecommSrv = $locator->get('R2Erp\Service\Ecommerce\EcommTransaction');

					$controller = new Controller\Checkout\CieloRestController($em, $ecommSrv);

					return $controller;
				},
				'R2Erp\Controller\CieloNotificationRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					$ecommSrv = $locator->get('R2Erp\Service\Ecommerce\EcommTransaction');

					$controller = new Controller\Notification\CieloNotificationRestController($em, $ecommSrv);

					return $controller;
				},
				'R2Erp\Controller\PagseguroNotificationRest' => function ($sm) {
					$locator = $sm->getServiceLocator();

					$em = $locator->get('Doctrine\ORM\EntityManager');
					$ecommSrv = $locator->get('R2Erp\Service\Ecommerce\EcommTransaction');

					$controller = new Controller\Notification\PagseguroNotificationRestController($em, $ecommSrv);

					return $controller;
				},
				'R2Erp\Controller\TestReturnRest' => function ($sm) {
					$controller = new Controller\Checkout\TestReturnRestController();

					return $controller;
				}
			),
		);
	}
}