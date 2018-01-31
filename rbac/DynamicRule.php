<?php
namespace app\rbac;

use app\components\rbac\models\DynamicUserPermission;
use yii\rbac\Item;
use yii\rbac\Rule;

class DynamicRule extends Rule
{
	public $name = 'dynamic';

	protected static $cache = [];
	/**
	 * Executes the rule.
	 *
	 * @param string|integer $user the user ID. This should be either an integer or a string representing
	 * the unique identifier of a user. See [[\yii\web\User::id]].
	 * @param Item $item the role or permission that this rule is associated with
	 * @param array $params parameters passed to [[ManagerInterface::checkAccess()]].
	 * @return boolean a value indicating whether the rule permits the auth item it is associated with.
	 */
	public function execute($user, $item, $params)
	{
		if (empty($params['p'])) {
			return false;
		}
		if (!isset(self::$cache[$user])) {
			self::$cache[$user] = DynamicUserPermission::getByUser($user);
		}
		if (isset(self::$cache[$user][$params['p']])) {
			return true;
		}
		return false;
	}
}