<?php

namespace R2Tracker\Service;

use Doctrine\ORM\EntityManager;
use R2Base\Service\AbstractService;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Mail\Transport\Smtp as SmtpTransport;

class UserTracker extends AbstractService {
	protected $transport;
	protected $view;
	private $authService;

	public function __construct(EntityManager $em, SmtpTransport $transport, $view) {
		parent::__construct($em);

		$this->entity = "R2Tracker\Entity\UserTracker";
		$this->transport = $transport;
		$this->view = $view;
	}

	public function getAuthService() {
		return $this->authService;
	}

	public function insert(array $data) {
		$server = $data['server'];
		unset($data['server']);
		$jsonIpInfo = file_get_contents("http://ipinfo.io/" . $server['userIp']);
		$arrIpInfo = json_decode($jsonIpInfo, true);

		$data['generationUri'] = $server['siteUri'];
		$data['userBrowser'] = $server['userBrowser'];
		$data['userBrowserLanguage'] = $server['userBrowserLanguage'];
		$data['userIp'] = $server['userIp'];

		if (isset($arrIpInfo['country'])) {
			$data['userCountry'] = $arrIpInfo['country'];
		}

		if (isset($arrIpInfo['region'])) {
			$data['userRegion'] = $arrIpInfo['region'];
		}

		if (isset($arrIpInfo['city'])) {
			$data['userCity'] = $arrIpInfo['city'];
		}

		if (isset($arrIpInfo['hostname'])) {
			$data['userHostname'] = $arrIpInfo['hostname'];
		}

		if (isset($arrIpInfo['org'])) {
			$data['userOrg'] = $arrIpInfo['org'];
		}

		if (isset($arrIpInfo['loc'])) {
			list($lat, $long) = explode(',', $arrIpInfo['loc']);
			$data['userLat'] = $lat;
			$data['userLong'] = $long;
		}

		$sessionStorage = new SessionStorage();
		$this->authService = new AuthenticationService;
		$this->authService->setStorage($sessionStorage);
		$data['logado'] = false;

		if ($this->getAuthService()->hasIdentity()) {
			$user = $this->getAuthService()->getIdentity();
			$userId = $user->getId();
			$role = $this->em->getReference('R2User\Entity\User', $userId)->getRole();
			$data['logado'] = true;
			$data['userRole'] = $role;
			$data['userId'] = $userId;
			// TODO if table has userId, then send to save...
			// unique id through javascript to create a public key...
			$entity = parent::insert($data);
		} else {

			$data['userRole'] = $this->em->getReference('R2Acl\Entity\Role', 1);
			$data['userId'] = $data['uniqueId'];
			$data['isRegistered'] = false;

			$data['userLastUri'] = $server['siteUri'];
			// unique id through javascript to create a public key...
			$entity = parent::insert($data);
		}

		return $entity;
	}

}

/*$jsonIpInfo = file_get_contents("http://ipinfo.io/" . $server['userIp']);
$arrIpInfo = json_decode($jsonIpInfo, true);*/

/*		$data = array(
'siteUri' => $server['siteUri'],
'userIp' => $server['userIp'],
'userBrowser' => $server['userBrowser'],
'userBrowserLanguage' => $server['userBrowserLanguage'],
'userCountry' => $arrIpInfo['country'],
'userRegion' => $arrIpInfo['region'],
'userCity' => $arrIpInfo['city'],
'userLat' => $arrIpInfo['loc'],
'userLong' => $arrIpInfo['loc'],
'userHostname' => $arrIpInfo['hostname'],
'userOrg' => $arrIpInfo['org'],
);*/

/*		if (isset($arrIpInfo['country'])) {
$data['userCountry'] = $arrIpInfo['country']
}

if (isset($arrIpInfo['region'])) {
$data['userRegion'] = $arrIpInfo['region']
}

if (isset($arrIpInfo['city'])) {
$data['userCity'] = $arrIpInfo['city']
}

if (isset($arrIpInfo['hostname'])) {
$data['userHostname'] = $arrIpInfo['hostname']
}

if (isset($arrIpInfo['org'])) {
$data['userOrg'] = $arrIpInfo['org']
}*/

/*		$sessionStorage = new SessionStorage();
$this->authService = new AuthenticationService;
$this->authService->setStorage($sessionStorage);

if ($this->getAuthService()->hasIdentity()) {
$user = $this->getAuthService()->getIdentity();
$data['userIdType'] = $user->getRole()->getNome();
} else {
$data['userIdType'] = 'Sem Registro';
}
 */