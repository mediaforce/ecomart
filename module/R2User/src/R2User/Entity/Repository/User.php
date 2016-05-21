<?php

namespace R2User\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class User extends EntityRepository {

	public function findArray() {

		$users = $this->findAll();
		$a = array();
		foreach ($users as $user) {
			$a[$user->getId()]['id'] = $user->getId();
		}

		return $a;
	}

	public function findByUser($user) {
		$user = $this->findOneByuser($user);

		if ($user) {
			return true;
		}

		return false;
	}

	public function findByUserAndPassword($user, $password) {
		$user = $this->findOneByuser($user);

		if ($user) {
			$hashPassword = $user->encryptPassword($password);
			if (is_null($user->getPassword())) {
				return false;
			}

			if ($hashPassword == $user->getPassword()) {
				return array('result' => true, 'user' => $user);
			} else {
				return array('result' => false, 'error' => 'Invalid password!');
			}

		} else {
			return array('result' => false, 'error' => 'This user is not registered!');
		}

	}
}
