<?php
namespace R2Base\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use R2Base\Entity\Strategy\MultiAssocStrategy;
use R2Base\Enum\Gender;
use Zend\Stdlib\Hydrator;
/**
 *
 * @ORM\Table(name="r2_base_people")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="R2Base\Entity\Repository\Person")
 */
class Person {
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
	 * @ORM\Column(name="name", type="string", length=255, nullable=true)
	 */
	private $name;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="surname", type="string", length=255, nullable=true)
	 */
	private $surname;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="gender", type="string", length=10, nullable=true)
	 */
	private $gender;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="nationality", type="string", length=50, nullable=true)
	 */
	private $nationality;
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="birth_date", type="datetime", nullable=true)
	 */
	private $birthDate;
	/**
	 * @ORM\OneToOne(targetEntity="R2Base\Entity\Image")
	 * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=true)
	 **/
	private $image;
	/**
	 * @ORM\ManyToMany(targetEntity="R2Base\Entity\Document", cascade={"persist", "remove"})
	 * @ORM\JoinTable(name="r2_base_person_documents",
	 *      joinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="document_id", referencedColumnName="id", unique=true)}
	 *      )
	 **/
	private $documents;
	/**
	 * @ORM\ManyToMany(targetEntity="R2Base\Entity\SocialNetwork", cascade={"persist", "remove"})
	 * @ORM\JoinTable(name="r2_base_person_social_networks",
	 *      joinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="social_network_id", referencedColumnName="id", unique=true)}
	 *      )
	 **/
	private $socialNetworks;
	/**
	 * @ORM\ManyToMany(targetEntity="R2Base\Entity\Email", cascade={"persist", "remove"})
	 * @ORM\JoinTable(name="r2_base_person_emails",
	 *      joinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="email_id", referencedColumnName="id", unique=true)}
	 *      )
	 **/
	private $emails;
	/**
	 * @ORM\ManyToMany(targetEntity="R2Base\Entity\Telephone", cascade={"persist", "remove"})
	 * @ORM\JoinTable(name="r2_base_person_telephones",
	 *      joinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="telephone_id", referencedColumnName="id", unique=true)}
	 *      )
	 **/
	private $telephones;
	/**
	 * @ORM\ManyToMany(targetEntity="R2Base\Entity\CreditCard", cascade={"persist", "remove"})
	 * @ORM\JoinTable(name="r2_base_person_credit_cards",
	 *      joinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="credit_card_id", referencedColumnName="id", unique=true)}
	 *      )
	 **/
	private $creditCards;
	/**
	 * @ORM\ManyToMany(targetEntity="R2Base\Entity\Address", cascade={"persist", "remove"})
	 * @ORM\JoinTable(name="r2_base_person_address",
	 *      joinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="address_id", referencedColumnName="id", unique=true)}
	 *      )
	 **/
	private $addresses;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="descricao", type="text", nullable=true)
	 */
	private $description;
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
		$this->documents = new ArrayCollection();
		$this->socialNetworks = new ArrayCollection();
		$this->emails = new ArrayCollection();
		$this->telephones = new ArrayCollection();
		$this->creditCards = new ArrayCollection();
		$this->addresses = new ArrayCollection();
		$this->createdAt = new \DateTime("now");
		$this->updatedAt = new \DateTime("now");
		(new Hydrator\ClassMethods)->hydrate($options, $this);
	}
	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}
	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	/**
	 * @param string $name
	 * @return Person
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getSurname() {
		return $this->surname;
	}
	/**
	 * @param string $surname
	 * @return Person
	 */
	public function setSurname($surname) {
		$this->surname = $surname;
		return $this;
	}
	/**
	 * @return string
	 */
	public function getGender() {
		return $this->gender;
	}
	/**
	 * @param string $gender
	 * @return Person
	 */
	public function setGender(Gender $gender) {
		$this->gender = $gender->value();
		return $this;
	}
	/**
	 * @return string
	 */
	public function getNationality() {
		return $this->nationality;
	}
	/**
	 * @param string $nationality
	 * @return Person
	 */
	public function setNationality($nationality) {
		$this->nationality = $nationality;
		return $this;
	}
	/**
	 * @return \DateTime
	 */
	public function getBirthDate() {
		return $this->birthDate;
	}
	/**
	 * @param \DateTime $birthDate
	 * @return Person
	 */
	public function setBirthDate(\DateTime $birthDate) {
		$this->birthDate = $birthDate;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getImage() {
		return $this->image;
	}
	/**
	 * @param mixed $photo
	 * @return Person
	 */
	public function setImage(Image $image) {
		$this->image = $image;
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
	 * @return Person
	 */
	public function setDocuments(ArrayCollection $documents) {
		$this->documents = $documents;
		return $this;
	}
	/**
	 * Sets the value of documentos.
	 *
	 * @param R2Base\Entity\Document $documents add document
	 *
	 * @return self
	 */
	public function addDocument(Document $document) {
		$this->documents->add($document);
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
	 * @return Person
	 */
	public function setSocialNetworks(ArrayCollection $socialNetworks) {
		$this->socialNetworks = $socialNetworks;
		return $this;
	}
	/**
	 * Sets the value of socialNetworks.
	 *
	 * @param R2Base\Entity\SocialNetwork $redeSocial add redes sociais
	 *
	 * @return self
	 */
	public function addSocialNetwork(SocialNetwork $socialNetwork) {
		$this->socialNetworks->add($socialNetwork);
		return $this;
	}
	/**
	 * Gets the value of emails.
	 *
	 * @return Doctrine\Common\Collections\ArrayCollection
	 */
	public function getEmails() {
		return $this->emails;
	}
	/**
	 * Sets the value of emails.
	 *
	 * @param mixed $emails the emails
	 *
	 * @return self
	 */
	public function setEmails(ArrayCollection $emails) {
		$this->emails = $emails;
		return $this;
	}
	/**
	 * Sets the value of emails.
	 *
	 * @param R2Base\Entity\Email $email add emails
	 *
	 * @return self
	 */
	public function addEmail(Email $email) {
		$this->emails->add($email);
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
	 * @return Person
	 */
	public function setTelephones(ArrayCollection $telephones) {
		$this->telephones = $telephones;
		return $this;
	}
	/**
	 * Sets the value of telephones.
	 *
	 * @param R2Base\Entity\Telephone $telephones add telephone
	 *
	 * @return self
	 */
	public function addTelephone(Telephone $telephone) {
		$this->telephones->add($telephone);
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getCreditCards() {
		return $this->creditCards;
	}
	/**
	 * @param mixed $creditCards
	 * @return Person
	 */
	public function setCreditCards(ArrayCollection $creditCards) {
		$this->creditCards = $creditCards;
		return $this;
	}
	/**
	 * Sets the value of creditCards.
	 *
	 * @param R2Base\Entity\CreditCard $CreditCard add creditCard
	 *
	 * @return self
	 */
	public function addCreditCard(CreditCard $creditCard) {
		$this->creditCards->add($creditCard);
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getAddresses() {
		return $this->addresses;
	}
	/**
	 * @param mixed $addresses
	 * @return Person
	 */
	public function setAddresses(ArrayCollection $addresses) {
		$this->addresses = $addresses;
		return $this;
	}
	/**
	 * Sets the value of enderecos.
	 *
	 * @param R2Base\Entity\Address $addresses add address
	 *
	 * @return self
	 */
	public function addAddress(Address $address) {
		$this->addresses->add($address);
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
	 * @return Person
	 */
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}
	/**
	 * Gets the value of createdAt.
	 *
	 * @return \DateTime
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}
	/**
	 * Gets the value of updatedAt.
	 *
	 * @return \DateTime
	 */
	public function getUpdatedAt() {
		return $this->updatedAt;
	}
	/**
	 * Sets the value of updatedAt.
	 *
	 * @param \DateTime $updatedAt the updated at
	 *
	 * @return self
	 *
	 * @ORM\PrePersist
	 */
	public function setUpdatedAt() {
		$this->updatedAt = new \Datetime("now");
		return $this;
	}
	public function toArray() {
		$person = (new Hydrator\ClassMethods())->extract($this);
		$person['addresses'] = (new MultiAssocStrategy())->extract($person['addresses']);
		$person['social_networks'] = (new MultiAssocStrategy())->extract($person['social_networks']);
		$person['documents'] = (new MultiAssocStrategy())->extract($person['documents']);
		$person['credit_cards'] = (new MultiAssocStrategy())->extract($person['credit_cards']);
		$person['emails'] = (new MultiAssocStrategy())->extract($person['emails']);
		$person['telephones'] = (new MultiAssocStrategy())->extract($person['telephones']);
		return $person;
	}
}