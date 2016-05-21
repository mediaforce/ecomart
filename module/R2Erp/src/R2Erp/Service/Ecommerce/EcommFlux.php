<?php
namespace R2Erp\Service\Ecommerce;

use Doctrine\Common\Collections\ArrayCollection;

class EcommFlux
{
    protected $em;
    protected $orderSaleSrv;
    protected $saleSrv;
    protected $paymentSrv;

    protected $items;
    protected $sales;
    protected $order;

    protected $paymentType;    // boleto, pagseguro e cielo;
    protected $paymentMethod;    // CREDITO, DEBITO ou BOLETO...

    public function __construct($em, $saleSrv, $orderSaleSrv, $paymentSrv)
    {
        $this->items = [];
        $this->order = null;
        $this->sales = new ArrayCollection();

        $this->em = $em;
        $this->orderSaleSrv = $orderSaleSrv;
        $this->saleSrv = $saleSrv;
        $this->paymentSrv = $paymentSrv;
    }

    public function setItems(array $items = array())
    {
        foreach ($items as $item) {
            $i = [];
            $i['isCombo'] = isset($item['_data']['isCombo'])?true:false;
            $i['id'] = $item['_id'];
            $i['quantity'] = $item['_quantity'];
            $i['unitPrice'] = $item['_price'];
            array_push($this->items, $i);
        }
        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function createSales()
    {
        foreach ($this->getItems() as $item) {
            $sale = [];
            if ($item['isCombo']) {
                $idC = explode('-', $item['id']);
                $sale['comboStore'] = $this->em->getReference('R2Erp\Entity\Order\Store\ComboStore', $idC[0]);
            } else {
                $sale['store'] = $this->em->getReference('R2Erp\Entity\Order\Store\Store', $item['id']);
            }

            $sale['quantity'] = $item['quantity'];
            $sale['unitPrice'] = number_format((float)$item['unitPrice'], 2, '.', '');
            $total = $item['quantity'] * $item['unitPrice'];
            $sale['totalPrice'] = number_format((float)$total, 2, '.', '');

            $sale = $this->saleSrv->insert($sale);

            $this->sales->add($sale);
        }

        $this->orderSaleSrv->update(array('id' => $this->getOrderId(), 'sales' => $this->sales));
        return $this; 
    }
    //($customer, $shippingType, $shippingCost, $totalOrder, $paymentType, $discount, $coupon)
    public function createOrder($customer, $shippingType, $shippingCost, $totalOrder, $paymentType, $discount = 0, $coupon = null)
    {
        $order['customer'] = $customer;
        $order['shippingType'] = new \R2Erp\Enum\ShippingType($shippingType);
        $order['shippingCost'] = (float)$shippingCost;
        $order['totalOrderCost'] = (float)$totalOrder;
        $order['paymentType'] = new \R2Erp\Enum\PaymentType($paymentType);
        $order['discount'] = (float)$discount;

        if (!is_null($coupon)) {
            $order['coupon'] =$this->em->getReference('R2Erp\Entity\Product\DiscountCoupon', $coupon);;
        }

        $this->order = $this->orderSaleSrv->insert($order);

        return $this;
    }

    public function setOrder($id) {
        $this->order = $this->em->getReference('R2Erp\Entity\Order\Sale\Order', $id);
        return $this;
    }

    public function getOrder() {
        return $this->order;
    }
    public function getOrderId() {
        return $this->order->getId();
    }

    public function createPayment($amount, $paymentStatus = 'Aguardando Pagamento', $paymentMethod = null, $currency = 986)
    {
        $payment = [];
        $payment['superOrder'] = $this->order;

        $payment['amountIncome'] = (float)$amount;
        $payment['invoiceDate'] = new \DateTime("now");
        $payment['currency'] = $this->em->getReference('R2Base\Entity\Currency', $currency);
        // $payment['invoiceDate'] = new \DateTime(date('Y-m-d H:i:s', strtotime($invoiceDate)));

        if (!is_null($paymentMethod)) {
            $payment['paymentMethod'] = new \R2Erp\Enum\PaymentMethod($paymentMethod);    
        }        

        $payment['status'] = $paymentStatus;

        $payment = $this->paymentSrv->insert($payment);

        $paymentsCollection = new ArrayCollection();
        $paymentsCollection->add($payment);

        $this->orderSaleSrv->update(array('id' => $this->getOrderId(), 'payments' => $paymentsCollection));

        return $this;
    }

    public function updateTid($tid) {
        $this->orderSaleSrv->update(array('id' => $this->getOrderId(), 'tid' => $tid));
        return $this; 
    }

    public function removeOrder() {

        try {
            $order = $this->em->getReference("R2Erp\Entity\Order\Sale\Order", $this->order->getId());

            foreach($order->getSales() as $sale) {
                $this->em->remove($sale);
                $this->em->flush();
                $order->getSales()->removeElement($sale);
            }
            $this->em->remove($order);

            $this->em->flush();

            //$res = $this->service->delete($id);   
            $res = true;
    
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        
        return $res;
        
    }

    public function removeSales() {
        try {
            $order = $this->em->getReference("R2Erp\Entity\Order\Sale\Order", $this->order->getId());

            foreach($order->getSales() as $sale) {
                $this->em->remove($sale);
                $this->em->flush();
                $order->getSales()->removeElement($sale);
            }

            $this->em->flush();

            //$res = $this->service->delete($id);   
            $res = true;
    
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        
        return $res;
    }

    public function updatePayment($paymentStatus) {
        $order = $this->getOrder($this->getOrderId());

        $payments = $order->getPayments();

        return $payments;

       /* if ($payments->count() > 0) {
            $payments->get(0)->setStatus($paymentStatus);
            $this->em->persist($payments->get(0));
            $this->em->flush();
        }*/



        return $this;
    }


}