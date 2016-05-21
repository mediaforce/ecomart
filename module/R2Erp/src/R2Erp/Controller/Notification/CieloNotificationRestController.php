<?php

namespace R2Erp\Controller\Notification;



use Zend\Mvc\Controller\AbstractRestfulController;

use Zend\View\Model\JsonModel;

use Zend\Authentication\AuthenticationService;

use Zend\Authentication\Storage\Session as SessionStorage;



use Cielo\Cielo;

use Cielo\CieloException;

use Cielo\Consultation;

use Cielo\Cancellation;





class CieloNotificationRestController extends AbstractRestfulController

{



    protected $em;

    protected $ecommSrv;



    public function __construct($em, $ecommSrv)

    {

        $this->em = $em;

        $this->ecommSrv = $ecommSrv;

        $this->serializer = \JMS\Serializer\SerializerBuilder::create()

            ->setPropertyNamingStrategy(new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(new \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy()))

            ->build();

    }



    // Listar - GET

    public function getList()

    {

        die('shit');



    }



    // Retornar o registro especifico - GET

    public function get($id)

    {

                

        $mid = '1047048431'; //seu merchant id

        $key = 'e48b6a4c35a46abce84c282d409edf06d2903f7addaebfd3e7dc474b2c28fee3';


        $cielo = new Cielo($mid, $key, Cielo::PRODUCTION);

        $consultation = $cielo->consultation($id);

        try {



              $consultationResponse = $cielo->consultationRequest($consultation);



                if (is_object($consultationResponse)){



                    

                    $arrConsult = [

                        'tid' => $consultationResponse->getTid(),

                        'status' => $consultationResponse->getStatus(),

                        'orderId' => $consultationResponse->getOrder()->getNumber(),

                        'AUTORIZATION MESSAGE' => $consultationResponse->getAuthorization()->getMessage(),

                        'AUTORIZATION DATE' => $consultationResponse ->getAuthorization()->getDateTime()



                    ];





                    $statusPayment =  null;

                    $removeSales = false;

                    switch((int)$consultationResponse->getStatus()) {

                        case 0:

                            $statusPayment =  'Transação Criada';

                            break;

                        case 1:

                            $statusPayment =  'Transação em Andamento';

                            break;

                        case 2:

                            $statusPayment =  'Transação Autenticada';

                            break;

                        case 3:

                            $statusPayment = 'Transação não Autenticada';

                            $removeSales = true;

                            break;

                        case 4:

                            $statusPayment = 'Transação Autorizada';

                            break;

                        case 5:

                            $statusPayment = 'Transação não Autorizada';

                            $removeSales = true;

                            break;

                        case 6:

                            $statusPayment = 'Transação Capturada';

                            break;

                        case 9:

                            $statusPayment = 'Transação Cancelada';

                            $removeSales = true;

                            break;

                        case 10:

                            $statusPayment = 'Transação em Autenticação ';

                            break;

                        case 12:

                            $statusPayment = 'Transação em Cancelamento';

                            break;

                    }

                    try {

                        $ecomm = $this->ecommSrv->setOrder($consultationResponse->getOrder()->getNumber());

                    } catch(\Exception $e) {

                        return new JsonModel(array('success' => false, 'erro_asdas' => $e->getMessage()));

                    }

                    

                        

                    if ($removeSales) {

                        $this->ecommSrv->removeSales();

                    }



                    $payment = $ecomm->getOrder()->getPayments()->get(0);

                    $payment->setStatus($statusPayment);

                    $this->em->persist($payment);

                    $this->em->flush();

                    $order = $ecomm->getOrder();

                    $data = json_decode($this->serializer->serialize($order, 'json'), true);



                    return new JsonModel(array('success' => true, 'order' => $data, 'transactionId' => $id, 'status' => $statusPayment));

    
                }





        } catch (CieloException $e) {



              return new JsonModel(array('success' => false));



        }

    }



    // alteracao - PUT

    public function update($id, $data)

    {

        return new JsonModel(array('success' => false));

    }



    // delete - DELETE

    public function delete($id)

    {

        $mid = '1047048431'; //seu merchant id

        $key = 'e48b6a4c35a46abce84c282d409edf06d2903f7addaebfd3e7dc474b2c28fee3';



        $ecomm = $this->ecommSrv->setOrder($id);



        $tid = $ecomm->getOrder()->getTid();



        $cielo = new Cielo($mid, $key, Cielo::PRODUCTION);



        $cancellation = $cielo->Cancellation($tid); //tid da transação



          try {



              $cancellationResponse = $cielo->cancellationRequest($cancellation);



                if (is_object($cancellationResponse)){



                  /*printf("TID=%s\n", $cancellationResponse->getTid());

                  printf("STATUS=%s\n", $cancellationResponse->getStatus());

                  printf("PAN=%s\n", $cancellationResponse->getPan());



                  printf("STATUS CODE=%s\n", $cancellationResponse->getCancellationInformation()->getCode());

                  printf("CACELLATION MESSAGE=%s\n", $cancellationResponse->getCancellationInformation()->getMessage());

                  printf("CACELLATION DATE=%s\n", $cancellationResponse ->getCancellationInformation()->getDateTime());

                  printf("CACELLATION VALUE=%s\n", $cancellationResponse->getCancellationInformation()->getValue());

                  return new JsonModel(array('success' => false, 'erro' => $e->getMessage(), 'error_code' => $e->getCode()));*/



                  $order = $ecomm->getOrder();

                  $data = json_decode($this->serializer->serialize($order, 'json'), true);



                  return new JsonModel(array('success' => true, 'msg' => $cancellationResponse->getStatus(), 'order' => $data));

                }





          } catch (CieloException $e) {



              return new JsonModel(array('success' => false, 'erro' => $e->getMessage(), 'error_code' => $e->getCode()));



          }

        //$data = json_decode($this->serializer->serialize($order, 'json'), true);

        return new JsonModel(array('success' => false));



    }

}