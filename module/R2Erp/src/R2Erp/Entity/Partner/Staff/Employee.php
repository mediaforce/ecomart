<?php

namespace R2Erp\Entity\Partner\Staff;



use Doctrine\ORM\Mapping as ORM;

use R2Erp\Entity\Partner\PartnerSuperClass;



/**
 *
 * @ORM\Table(name="r2_erp_partner_staff_employees")
 * @ORM\Entity
 */

class Employee extends PartnerSuperClass {

	private $salaryType;

	private $workCard;

	private $payDay;

}