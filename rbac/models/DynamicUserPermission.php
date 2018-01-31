<?php
namespace app\components\rbac\models;

use app\components\models\AccountModel;

/**
 * Class DynamicPermission
 * @property integer $id
 * @property integer $ACCOUNT_ID
 * @property integer $user_id
 * @property integer $permission_id
 *
 * @property DynamicPermission permission
 */
class DynamicUserPermission extends AccountModel
{
	public static function tableName()
	{
		return 'user.dynamic_user_permission';
	}

	public function getPermission()
	{
		return $this->hasOne(DynamicPermission::class, ['id' => 'permission_id']);
	}

	/**
	 * @param $userId
	 * @return self[]
	 */
	public static function getByUser($userId)
	{
		/** @var self[] $relations */
		$relations = self::find()->with('permission')->where(['user_id' => $userId])->all();
		$permissions = [];
		foreach ($relations as $relation) {
			$permissions[$relation->permission->name] = $relation;
		}

		return $permissions;
	}

	public static function create($userId, $permission)
	{
		$permissionModel = DynamicPermission::getByName($permission);
		$model = new self();
		$model->user_id = $userId;
		$model->permission_id = $permissionModel->id;
		$model->save();

		return $model;
	}
}