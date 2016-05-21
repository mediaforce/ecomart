<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace R2SiteApp\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use R2Base\Mail\Mail;
class IndexController extends AbstractActionController {
	private $em;

	public function __construct($em) {
		$this->em = $em;
	}



	public function indexAction() {
		return new ViewModel();
	}
}