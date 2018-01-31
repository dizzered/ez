<?php
namespace app\rbac;

use app\models\User;
use Yii;
use yii\rbac\Rule;

class UserRoleRule extends Rule
{
	public $name = 'userRole';
	static $userCache = [];

	public function execute($userId, $item, $params)
	{
		if (!$userId) {
			return false;
		}
		if ($userId == -1) {
			return $item->name == "guest";
		}
		if ($userId == -2) {
			return true;
		}
		/** @var User $user */
		if (!isset(self::$userCache[$userId])) {
			self::$userCache[$userId] = User::findOne($userId);
		}
		$user = self::$userCache[$userId];

		if (!$user) {
			return $item->name == "guest";
		}
		if ($this->check($user, $item)) {
			return true;
		}

		return false;
	}

	protected function check($user, $item)
	{
		switch ($item->name) {
			case 'god':
				return 'god' == $user->type;
			case 'admin':
				return in_array($user->type, ['admin', 'god']);
			case 'user':
				return 0 != $user->id && -1 != $user->id;
				break;
			case 'guest':
				break;
		}
		return $item->name == $user->type;
	}
}