<?php
namespace R2Erp\Entity\Partner;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
/**
 * @ORM\Table(name="r2_erp_staff_partners")
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap(
 * 		{
 *   		"PartnerSuperClass" = "PartnerSuperClass",
 *     		"PartnerBusiness" = "R2Erp\Entity\Partner\Staff\Business",
 *     		"PartnerFinancial" = "R2Erp\Entity\Partner\Staff\Financial",
 *     		"PartnerContractor" = "R2Erp\Entity\Partner\Staff\Contractor",
 *     		"PartnerCopartner" = "R2Erp\Entity\Partner\Staff\Copartner",
 *     		"PartnerEmployee" = "R2Erp\Entity\Partner\Staff\Employee",
 *     		"PartnerThirdParty" = "R2Erp\Entity\Partner\Staff\ThirdParty",
 *      })
 */
class PartnerSuperClass {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	/**
	 * @ORM\OneToOne(targetEntity="R2Base\Entity\Person")
	 * @ORM\JoinColumn(name="person_id", referencedColumnName="id", nullable=true)
	 **/
	private $person;
	/**
	 * @ORM\OneToOne(targetEntity="R2Erp\Entity\Partner\Department")
	 * @ORM\JoinColumn(name="department_id", referencedColumnName="id", nullable=true)
	 **/
	private $department;
	/**
	 * @ORM\ManyToMany(targetEntity="R2Erp\Entity\Partner\Burden")
	 * @ORM\JoinTable(name="r2_erp_staff_partner_burdens",
	 *      joinColumns={@ORM\JoinColumn(name="employee_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="burden_id", referencedColumnName="id", unique=true)}
	 *      )
	 **/
	private $burdens;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="is_on_comission", type="boolean")
	 */
	private $isOnComission;
	/**
	 * @ORM\ManyToOne(targetEntity="R2Erp\Entity\Financial\AccountSuperClass")
	 * @ORM\JoinTable(name="r2_erp_partner_accounts",
	 *      joinColumns={@ORM\JoinColumn(name="partner_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="account_id", referencedColumnName="id", unique=true)}
	 *      )
	 **/
	private $accounts;
	/**
	 * @ORM\ManyToOne(targetEntity="R2Erp\Entity\Order\Expense\Order")
	 * @ORM\JoinTable(name="r2_erp_partner_expenses",
	 *      joinColumns={@ORM\JoinColumn(name="partnerr_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="expense_order_id", referencedColumnName="id", unique=true)}
	 *      )
	 **/
	private $expenses;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="partner_status", type="string", length=20, nullable=false)
	 */
	private $partnerStatus;
	public function __construct(array $options = array()) {
		(new Hydrator\ClassMethods)->hydrate($options, $this);
	}
}