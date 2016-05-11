<?php

namespace R2Tracker\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * R2TrackerUserTracker
 *
 * @ORM\Table(name="r2_user_tracks")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="R2TuTracker\Entity\Repository\UserTracker")
 */
class UserTracker {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="generation_time", type="datetime", nullable=true)
	 */
	private $generationTime;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="generation_uri", type="string", nullable=true)
	 *
	 */
	private $generationUri;

	/**
	 * @var integer
	 * @ORM\Column(name="user_id", type="string", nullable=false, unique=true)
	 */
	private $userId;

	/**
	 * @ORM\ManyToOne(targetEntity="R2Acl\Entity\Role")
	 * @ORM\JoinColumn(name="user_role_id", referencedColumnName="id", nullable=false)
	 **/
	private $userRole;

	/**
	 * @ORM\Column(type="boolean", name="is_registered", nullable=false)
	 * @var boolean
	 */
	private $isRegistered;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="public_key", type="string", length=100, nullable=true)
	 */
	private $publicKey;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="user_ip", type="string", length=128, nullable=true)
	 */
	private $userIp;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="user_browser", type="string", nullable=true)
	 *
	 */
	private $userBrowser;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="user_browser_language", type="string", nullable=true)
	 *
	 */
	private $userBrowserLanguage;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="user_resolution", type="string", nullable=true)
	 *
	 */
	private $userResolution;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="user_country", type="string", nullable=true)
	 *
	 */
	private $userCountry;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="user_region", type="string", nullable=true)
	 *
	 */
	private $userRegion;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="user_city", type="string", nullable=true)
	 *
	 */
	private $userCity;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="user_lat", type="string", nullable=true)
	 *
	 */
	private $userLat;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="user_long", type="string", nullable=true)
	 *
	 */
	private $userLong;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="user_hostname", type="string", nullable=true)
	 *
	 */
	private $userHostname;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="user_org", type="string", nullable=true)
	 *
	 */
	private $userOrg;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="user_local_time", type="string", nullable=true)
	 *
	 */
	private $userLocalTime;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="user_last_visit_time", type="datetime", nullable=true)
	 *
	 */
	private $userLastVisitTime;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="user_last_uri", type="string", nullable=true)
	 *
	 */
	private $userLastUri;

	/**
	 * @var text
	 * @ORM\Column(name="page_custom_var", type="text", nullable=true)
	 */
	private $pageCustomVar;

	/**
	 * @var text
	 * @ORM\Column(name="event_custom_var", type="text", nullable=true)
	 */
	private $eventCustomVar;

	/**
	 * @var text
	 * @ORM\Column(name="visitor_custom_var", type="text", nullable=true)
	 */
	private $visitorCustomVar;

	/**
	 * @var text
	 * @ORM\Column(name="e_commerce_items", type="text", nullable=true)
	 */
	private $ecommerceItems;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="expires_at", type="datetime", nullable=true)
	 */
	private $expires_at;

	public function __construct(array $options = array()) {

		$this->setGenerationTime(new \DateTime("now"))
			->setUserLastVisitTime(new \DateTime("now"));

		(new Hydrator\ClassMethods)->hydrate($options, $this);

	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return \DateTime
	 */
	public function getGenerationTime() {
		return $this->generationTime;
	}

	/**
	 * @param \DateTime $generationTime
	 */
	public function setGenerationTime($generationTime) {
		$this->generationTime = $generationTime;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getGenerationUri() {
		return $this->generationUri;
	}

	/**
	 * @param string $generationUri
	 */
	public function setGenerationUri($generationUri) {
		$this->generationUri = $generationUri;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getUserId() {
		return $this->userId;
	}

	/**
	 * @param int $userId
	 */
	public function setUserId($userId) {
		$this->userId = $userId;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUserRole() {
		return $this->userRole;
	}

	/**
	 * @param string $userIdType
	 */
	public function setUserRole($userRole) {
		$this->userRole = $userRole;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPublicKey() {
		return $this->publicKey;
	}

	/**
	 * @param string $publicKey
	 */
	public function setPublicKey($publicKey) {
		$this->publicKey = $publicKey;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUserIp() {
		return $this->userIp;
	}

	/**
	 * @param string $userIp
	 */
	public function setUserIp($userIp) {
		$this->userIp = $userIp;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUserBrowser() {
		return $this->userBrowser;
	}

	/**
	 * @param string $userBrowser
	 */
	public function setUserBrowser($userBrowser) {
		$this->userBrowser = $userBrowser;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUserBrowserLanguage() {
		return $this->userBrowserLanguage;
	}

	/**
	 * @param string $userBrowserLanguage
	 */
	public function setUserBrowserLanguage($userBrowserLanguage) {
		$this->userBrowserLanguage = $userBrowserLanguage;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUserResolution() {
		return $this->userResolution;
	}

	/**
	 * @param string $userResolution
	 */
	public function setUserResolution($userResolution) {
		$this->userResolution = $userResolution;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUserCountry() {
		return $this->userCountry;
	}

	/**
	 * @param string $userCountry
	 */
	public function setUserCountry($userCountry) {
		$this->userCountry = $userCountry;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUserRegion() {
		return $this->userRegion;
	}

	/**
	 * @param string $userRegion
	 */
	public function setUserRegion($userRegion) {
		$this->userRegion = $userRegion;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUserCity() {
		return $this->userCity;
	}

	/**
	 * @param string $userCity
	 */
	public function setUserCity($userCity) {
		$this->userCity = $userCity;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUserLat() {
		return $this->userLat;
	}

	/**
	 * @param string $userLat
	 */
	public function setUserLat($userLat) {
		$this->userLat = $userLat;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUserLong() {
		return $this->userLong;
	}

	/**
	 * @param string $userLong
	 */
	public function setUserLong($userLong) {
		$this->userLong = $userLong;
		return $this;
	}

	/**
	 * Gets the value of userHostname.
	 *
	 * @return string
	 */
	public function getUserHostname() {
		return $this->userHostname;
	}

	/**
	 * Sets the value of userHostname.
	 *
	 * @param string $userHostname the user hostname
	 *
	 * @return self
	 */
	public function setUserHostname($userHostname) {
		$this->userHostname = $userHostname;

		return $this;
	}

	/**
	 * Gets the value of userOrg.
	 *
	 * @return string
	 */
	public function getUserOrg() {
		return $this->userOrg;
	}

	/**
	 * Sets the value of userOrg.
	 *
	 * @param string $userOrg the user org
	 *
	 * @return self
	 */
	public function setUserOrg($userOrg) {
		$this->userOrg = $userOrg;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getUserLocalTime() {
		return $this->userLocalTime;
	}

	/**
	 * @param string $userLocalTime
	 */
	public function setUserLocalTime($userLocalTime) {
		$this->userLocalTime = $userLocalTime;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUserLastVisitTime() {
		return $this->userLastVisitTime;
	}

	/**
	 * @param string $userLastVisitTime
	 */
	public function setUserLastVisitTime($userLastVisitTime) {
		$this->userLastVisitTime = $userLastVisitTime;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUserLastUri() {
		return $this->userLastUri;
	}

	/**
	 * @param string $userLastUri
	 */
	public function setUserLastUri($userLastUri) {
		$this->userLastUri = $userLastUri;
		return $this;
	}

	/**
	 * @return text
	 */
	public function getPageCustomVar() {
		return $this->pageCustomVar;
	}

	/**
	 * @param text $pageCustomVar
	 */
	public function setPageCustomVar($pageCustomVar) {
		$this->pageCustomVar = $pageCustomVar;
		return $this;
	}

	/**
	 * @return text
	 */
	public function getEventCustomVar() {
		return $this->eventCustomVar;
	}

	/**
	 * @param text $eventCustomVar
	 */
	public function setEventCustomVar($eventCustomVar) {
		$this->eventCustomVar = $eventCustomVar;
		return $this;
	}

	/**
	 * @return text
	 */
	public function getVisitorCustomVar() {
		return $this->visitorCustomVar;
	}

	/**
	 * @param text $visitorCustomVar
	 */
	public function setVisitorCustomVar($visitorCustomVar) {
		$this->visitorCustomVar = $visitorCustomVar;
		return $this;
	}

	/**
	 * @return text
	 */
	public function getEcommerceItems() {
		return $this->ecommerceItems;
	}

	/**
	 * @param text $ecommerceItems
	 */
	public function setEcommerceItems($ecommerceItems) {
		$this->ecommerceItems = $ecommerceItems;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getExpiresAt() {
		return $this->expires_at;
	}

	/**
	 * @param \DateTime $expires_at
	 */
	public function setExpiresAt($expires_at) {
		$this->expires_at = $expires_at;
		return $this;
	}

	/**
	 * Gets the value of isRegistered.
	 *
	 * @return boolean
	 */
	public function getIsRegistered() {
		return $this->isRegistered;
	}

	/**
	 * Gets the value of isRegistered.
	 *
	 * @return boolean
	 */
	public function isRegistered() {
		return $this->isRegistered;
	}

	/**
	 * Sets the value of isRegistered.
	 *
	 * @param boolean $isRegistered the is registered
	 *
	 * @return self
	 */
	public function setIsRegistered($isRegistered) {
		$this->isRegistered = $isRegistered;

		return $this;
	}
}
