<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 06/03/2016
 * Time: 15:12
 */
namespace R2Erp\Entity\Order\Expense;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
//TEMP: advertising, art, bussinessgift, depreciation, due, energy, freight, fuel, gas, good, gratuity, insurance, internet, legal, localtransp, maintenance, meal, mortgage, office, repair, research, service, study, supply, tax, telephone, travel, uniform, utilify, vehicle...
/**
 *
 * @ORM\Table(name="r2_erp_expense_order_expense_categories")
 * @ORM\Entity
 */
class ExpenseCategory {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	/**
	 * @ORM\Column(name="title", type="string", length=15, nullable=false)
	 */
	private $title;
	/**
	 * @ORM\Column(name="description", type="text", nullable=true)
	 */
	private $description;
	public function __construct(array $options = array()) {
		if (array_key_exists('title', $options)) {
			$this->title = $options['title'];
		}
		(new Hydrator\ClassMethods)->hydrate($options, $this);
	}
}