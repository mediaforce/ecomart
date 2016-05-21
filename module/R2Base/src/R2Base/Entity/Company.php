<?php
namespace R2Base\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\AccessType;
use JMS\Serializer\Annotation\Type;
use Zend\Stdlib\Hydrator;
/**
 *
 * @ORM\Table(name="r2_base_companies")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="R2Base\Entity\Repository\Company")
 * @AccessType("public_method")
 */
class Company {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="company_type", type="string", length=15, nullable=false)
	 */
	private $companyType;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="trading_name", type="string", length=60, nullable=true)
	 *
	 */
	private $tradingName;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="company_name", type="string", length=60, nullable=false)
	 */
	private $companyName;
	/**
	 * @ORM\ManyToMany(targetEntity="R2Base\Entity\CompanyCategory")
	 * @ORM\JoinColumn(name="company_category", referencedColumnName="id", nullable=true)
	 **/
	private $companyCategory;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="website", type="string", length=100, nullable=true)
	 */
	private $website;
	/**
	 * @ORM\ManyToMany(targetEntity="R2Base\Entity\Person")
	 * @ORM\JoinTable(name="r2_base_company_contacts",
	 *      joinColumns={@ORM\JoinColumn(name="company_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id", unique=true)}
	 *      )
	 **/
	private $contacts;
	/**
	 * @ORM\ManyToMany(targetEntity="R2Base\Entity\Document", cascade={"persist", "remove"})
	 * @ORM\JoinTable(name="r2_base_company_documents",
	 *      joinColumns={@ORM\JoinColumn(name="company_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="document_id", referencedColumnName="id", unique=true)}
	 *      )
	 **/
	private $documents;
	/**
	 * @ORM\ManyToMany(targetEntity="R2Base\Entity\Email", cascade={"persist", "remove"})
	 * @ORM\JoinTable(name="r2_base_company_emails",
	 *      joinColumns={@ORM\JoinColumn(name="company_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="email_id", referencedColumnName="id", unique=true)}
	 *      )
	 **/
	private $emails;
	/**
	 * @ORM\ManyToMany(targetEntity="R2Base\Entity\SocialNetwork", cascade={"persist", "remove"})
	 * @ORM\JoinTable(name="r2_base_company_social_networks",
	 *      joinColumns={@ORM\JoinColumn(name="company_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="social_network_id", referencedColumnName="id", unique=true)}
	 *      )
	 **/
	private $socialNetworks;
	/**
	 * @ORM\ManyToMany(targetEntity="R2Base\Entity\Telephone", cascade={"persist", "remove"})
	 * @ORM\JoinTable(name="r2_base_company_telephones",
	 *      joinColumns={@ORM\JoinColumn(name="company_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="telephone_id", referencedColumnName="id", unique=true)}
	 *      )
	 **/
	private $telephones;
	/**
	 * @ORM\OneToOne(targetEntity="R2Base\Entity\Address", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(name="address_id", referencedColumnName="id", nullable=true)
	 **/
	private $address;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="description", type="text", nullable=true)
	 */
	private $description;
	/**
	 * @ORM\OneToOne(targetEntity="R2Base\Entity\Image", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(name="logo", referencedColumnName="id", nullable=true)
	 **/
	private $logo;
	/**
	 * @ORM\ManyToMany(targetEntity="R2Base\Entity\GoodTag")
	 * @ORM\JoinTable(name="r2_base_company_goods",
	 *      joinColumns={@ORM\JoinColumn(name="company_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="good_tag_id", referencedColumnName="id", unique=true)}
	 *      )
	 **/
	private $goodTags;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="notes", type="string", length=50, nullable=true)
	 */
	private $notes;
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="foundation_date", type="datetime", nullable=true)
	 */
	private $foundationDate;
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
	public function __construct(array $options = array()) {
		$this->createdAt = new \DateTime("now");
		$this->updatedAt = new \DateTime("now");
		$this->documents = new ArrayCollection();
		$this->socialNetworks = new ArrayCollection();
		$this->emails = new ArrayCollection();
		$this->telephones = new ArrayCollection();
		$this->addresses = new ArrayCollection();
		$this->sourceTags = new ArrayCollection();
		(new Hydrator\ClassMethods)->hydrate($options, $this);
	}
	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}
	/**
	 * @param int $id
	 * @return Company
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getCompanyType() {
		return $this->companyType;
	}
	/**
	 * @param string $companyType
	 * @return Company
	 */
	public function setCompanyType(\R2Base\Enum\CompanyType $companyType) {
		$this->companyType = $companyType->value();
		return $this;
	}
	/**
	 * @return string
	 */
	public function getTradingName() {
		return $this->tradingName;
	}
	/**
	 * @param string $tradingName
	 * @return Company
	 */
	public function setTradingName($tradingName) {
		$this->tradingName = $tradingName;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getCompanyName() {
		return $this->companyName;
	}
	/**
	 * @param string $companyName
	 * @return Company
	 */
	public function setCompanyName($companyName) {
		$this->companyName = $companyName;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getCompanyCategory() {
		return $this->companyCategory;
	}
	/**
	 * @param mixed $companyCategory
	 * @return Company
	 */
	public function setCompanyCategory($companyCategory) {
		$this->companyCategory = $companyCategory;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getWebsite() {
		return $this->website;
	}
	/**
	 * @param string $website
	 * @return Company
	 */
	public function setWebsite($website) {
		$this->website = $website;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getContacts() {
		return $this->contacts;
	}
	/**
	 * @param mixed $contacts
	 * @return Company
	 */
	public function setContacts(ArrayCollection $contacts) {
		$this->contacts = $contacts;
		return $this;
	}
	public function addContact(\R2Base\Entity\Person $contact) {
		$this->contacts->add($contact);
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getDocuments() {
		return $this->documents;
	}
	/**
	 * @param mixed $documents
	 * @return Company
	 */
	public function setDocuments(ArrayCollection $documents) {
		$this->documents = $documents;
		return $this;
	}
	public function addDocument(\R2Base\Entity\Document $document) {
		$this->documents->add($document);
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getEmails() {
		return $this->emails;
	}
	/**
	 * @param mixed $emails
	 * @return Company
	 */
	public function setEmails(ArrayCollection $emails) {
		$this->emails = $emails;
		return $this;
	}
	public function addEmail(\R2Base\Entity\Email $email) {
		$this->emails->add($email);
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getSocialNetworks() {
		return $this->socialNetworks;
	}
	/**
	 * @param mixed $socialNetworks
	 * @return Company
	 */
	public function setSocialNetworks(ArrayCollection $socialNetworks) {
		$this->socialNetworks = $socialNetworks;
		return $this;
	}
	public function addSocialNetwork(\R2Base\Entity\SocialNetwork $socialNetwork) {
		$this->socialNetworks->add($socialNetwork);
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getTelephones() {
		return $this->telephones;
	}
	/**
	 * @param mixed $telephones
	 * @return Company
	 */
	public function setTelephones(ArrayCollection $telephones) {
		$this->telephones = $telephones;
		return $this;
	}
	public function addTelephone(\R2Base\Entity\Telephone $telephone) {
		$this->telephones->add($telephone);
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getAddress() {
		return $this->address;
	}
	/**
	 * @param mixed $address
	 * @return Company
	 */
	public function setAddress($address) {
		$this->address = $address;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}
	/**
	 * @param string $description
	 * @return Company
	 */
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getLogo() {
		return $this->logo;
	}
	/**
	 * @param mixed $logo
	 * @return Company
	 */
	public function setLogo($logo) {
		$this->logo = $logo;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getGoodTags() {
		return $this->goodTags;
	}
	/**
	 * @param mixed $goodTags
	 * @return Company
	 */
	public function setGoodTags(ArrayCollection $goodTags) {
		$this->goodTags = $goodTags;
		return $this;
	}
	public function addGoodTag(\R2Base\Entity\GoodTag $goodTag) {
		$this->goodTags->add($goodTag);
		return $this;
	}
	/**
	 * @return string
	 */
	public function getNotes() {
		return $this->notes;
	}
	/**
	 * @param string $notes
	 * @return Company
	 */
	public function setNotes($notes) {
		$this->notes = $notes;
		return $this;
	}
	/**
	 * @return \DateTime
	 */
	public function getFoundationDate() {
		return $this->foundationDate;
	}
	/**
	 * @param \DateTime $foundationDate
	 * @return Company
	 */
	public function setFoundationDate($foundationDate) {
		$this->foundationDate = $foundationDate;
		return $this;
	}
	/**
	 * @return \DateTime
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}
	/**
	 * @param \DateTime $createdAt
	 * @return Company
	 */
	public function setCreatedAt($createdAt) {
		$this->createdAt = $createdAt;
		return $this;
	}
	/**
	 * @return \DateTime
	 */
	public function getUpdatedAt() {
		return $this->updatedAt;
	}
	/**
	 * @param \DateTime $updatedAt
	 * @return Company
	 *
	 * @ORM\PrePersist
	 */
	public function setUpdatedAt() {
		$this->updatedAt = new \DateTime("now");
		return $this;
	}
	public function toArray() {
		/*$company = (new Hydrator\ClassMethods())->extract($this);
			$company['emails'] = (new MultiAssocStrategy())->extract($company['emails']);
			$a = array();
			$a[$this->getId()]['companyType'] = $this->getCompanyType();
			$a[$this->getId()]['tradingName'] = $this->getTradingName();
			$a[$this->getId()]['companyName'] = $this->getCompanyName();
			$a[$this->getId()]['category'] = $this->getCategory()->toArray();
			$a[$this->getId()]['website'] = $this->getWebsite();
			$a[$this->getId()]['documents'] = $this->getDocuments();
			$a[$this->getId()]['emails'] = $this->getEmails()[0]->getAddress();
			$a[$this->getId()]['socialNetworks'] = $this->getSocialNetworks();
			$a[$this->getId()]['telephones'] = $this->getTelephones();
			$a[$this->getId()]['address'] = $this->getAddress();
			$a[$this->getId()]['description'] = $this->getDescription();
			$a[$this->getId()]['logo'] = $this->getLogo();
			$a[$this->getId()]['goodTags'] = $this->getGoodTags();
			$a[$this->getId()]['notes'] = $this->getNotes();
			$a[$this->getId()]['foundationDate'] = $this->getFoundationDate();
			$a[$this->getId()]['createdAt'] = $this->getCreatedAt();
			$a[$this->getId()]['updatedAt'] = $this->getUpdatedAt();
		*/
		return (new Hydrator\ClassMethods())->extract($this);
	}
}