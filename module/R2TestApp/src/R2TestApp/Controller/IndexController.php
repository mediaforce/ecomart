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

use Cielo\Cielo;
use Cielo\CieloException;

use R2Base\Mail\Mail;
use Zend\View\Model\JsonModel;


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

		$mid = '1047048431'; //seu merchant id
        $key = 'e48b6a4c35a46abce84c282d409edf06d2903f7addaebfd3e7dc474b2c28fee3';

		$cielo = new Cielo($mid, $key, Cielo::PRODUCTION);

        $consultation = $cielo->consultation('1047048431000000432A'); //tid da transação

        try {

              $consultationResponse = $cielo->consultationRequest($consultation);

                if (is_object($consultationResponse)){


                  printf("TID=%s\n", $consultationResponse->getTid());
                  printf("STATUS=%s\n", $consultationResponse->getStatus());
                  printf("PAN=%s\n", $consultationResponse->getPan());

                  printf("AUTORIZATION CODE=%s\n", $consultationResponse->getAuthorization()->getCode());
                  printf("AUTORIZATION MESSAGE=%s\n", $consultationResponse->getAuthorization()->getMessage());
                  printf("AUTORIZATION DATE=%s\n", $consultationResponse ->getAuthorization()->getDateTime());

                }


          } catch (CieloException $e) {

              printf("Opz[%d]: %s\n", $e->getCode(), $e->getMessage());

          }

          die;



		/*$mail = new Mail($this->transport, $this->view, 'teste');



		$mail->setSubject('Isso é um teste!')

			->setTo('dnaloco@gmail.com')

			->setData(array())

			->prepare()

			->send();



		echo 'test mail';*/

		die;



		//return new ViewModel();

	}

}

