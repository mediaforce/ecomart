<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace R2TestApp\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use R2Base\Mail\Mail;

class IndexController extends AbstractActionController {

	private $em;
	private $transport;
	private $view;

	public function __construct($em, $transport, $view) {
		$this->em = $em;
		$this->transport = $transport;
		$this->view = $view;
	}

	public function indexAction() {

		$mail = new Mail($this->transport, $this->view, 'teste');

		$mail->setSubject('Isso é um teste!')
			->setTo('arthur_scosta@yahoo.com.br')
			->setData(array())
			->prepare()
			->send();

		echo 'test mail';
		die;

		//return new ViewModel();
	}
}
