<?php
namespace R2Erp\Entity\Financial;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 *
 * @ORM\Table(name="r2_erp_financial_payments")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Payment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="R2Erp\Entity\Order\OrderSuperClass", inversedBy="payments")
     * @ORM\JoinColumn(name="super_order_id", referencedColumnName="id")
     */
    private $superOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="amount_income", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $amountIncome;

    /**
     * @var string
     *
     * @ORM\Column(name="total_parcels", type="integer", nullable=true)
     */
    private $totalParcels;

    /**
     * @var string
     *
     * @ORM\Column(name="interests_free", type="boolean", nullable=true)
     */
    private $interestsFree;

    /**
     * @var string
     *
     * @ORM\Column(name="installment_amount", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $installmentAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="amount_outcome", type="decimal", precision=8, scale=2, nullable=true)
     */
    private $amountOutcome;

    /**
     * @ORM\ManyToOne(targetEntity="R2Base\Entity\Currency")
     * @ORM\JoinColumn(name="currency", referencedColumnName="id", nullable=false)
     */
    private $currency;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="invoice_date", type="datetime", nullable=true)
     */
    private $invoiceDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiration_date", type="datetime", nullable=true)
     */
    private $expirationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="payment_date", type="datetime", nullable=true)
     */
    private $paymentDate;

    /**
     * @ORM\Column(name="payment_method", type="string", length=75, nullable=true)
     */
    private $paymentMethod;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="credit_card_auth_code", type="string", nullable=true)
     */
    private $creditCardAuthCode;

    /**
     * @ORM\ManyToOne(targetEntity="R2Erp\Entity\Financial\AccountSuperClass")
     * @ORM\JoinColumn(name="to_account", referencedColumnName="id", nullable=true)
     **/
    private $toAccount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var string
     *,
     * @ORM\Column(name="status", type="string", length=255, nullable=false)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="excrow_end_aate", type="datetime", nullable=true)
     */
    private $escrowEndDate;

    /**
     * @var string
     *,
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    public function __construct(array $options = array())
    {
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = new \DateTime("now");
        $this->invoiceDate = $this->createdAt;
        (new Hydrator\ClassMethods)->hydrate($options, $this);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Payment
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getAmountIncome()
    {
        return $this->amountIncome;
    }

    /**
     * @param string $amountIncome
     * @return Payment
     */
    public function setAmountIncome($amountIncome)
    {
        $this->amountIncome = $amountIncome;
        return $this;
    }

    /**
     * @return string
     */
    public function getAmountOutcome()
    {
        return $this->amountOutcome;
    }

    /**
     * @param string $amountOutcome
     * @return Payment
     */
    public function setAmountOutcome($amountOutcome)
    {
        $this->amountOutcome = $amountOutcome;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     * @return Payment
     */
    public function setCurrency(\R2Base\Entity\Currency $currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getInvoiceDate()
    {
        return $this->invoiceDate;
    }

    /**
     * @param \DateTime $invoiceDate
     * @return Payment
     */
    public function setInvoiceDate($invoiceDate)
    {
        $this->invoiceDate = $invoiceDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * @param \DateTime $expirationDate
     * @return Payment
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * @param \DateTime $paymentDate
     * @return Payment
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSuperOrder()
    {
        return $this->superOrder;
    }

    /**
     * @param mixed $superOrder
     * @return Payment
     */
    public function setSuperOrder($superOrder)
    {
        $this->superOrder = $superOrder;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param mixed $paymentMethod
     * @return Payment
     */
    public function setPaymentMethod(\R2Erp\Enum\PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod->value();
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreditCardAuthCode()
    {
        return $this->creditCardAuthCode;
    }

    /**
     * @param \DateTime $creditCardAuthCode
     * @return Payment
     */
    public function setCreditCardAuthCode($creditCardAuthCode)
    {
        $this->creditCardAuthCode = $creditCardAuthCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getToAccount()
    {
        return $this->toAccount;
    }

    /**
     * @param mixed $toAccount
     * @return Payment
     */
    public function setToAccount($toAccount)
    {
        $this->toAccount = $toAccount;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Payment
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return Payment
     *
     * @ORM\PrePersist
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime("now");
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Order
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Gets the ,.
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Sets the ,.
     *
     * @param string $notes the notes
     *
     * @return self
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }
}