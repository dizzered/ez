<?php
namespace app\components\rbac\models;

use app\components\core\exceptions\ModelErrorException;
use app\components\features\Features;
use app\components\models\AccountModel;
use app\components\saas\models\Account;

/**
 * Class DynamicPermission
 * @property integer $id
 * @property integer $ACCOUNT_ID
 * @property integer $name
 */
class DynamicPermission extends AccountModel
{
	const CMS_MODULE = 'cms:module';
	const NOTIFICATIONS_MODULE = 'notifications:module';
	const SALES_OFFER_CONTROLLER = 'sales:offer:controller';
	const USER_SURVEY_CONTROLLER = 'user:control:survey:controller';
	const NOTIFICATIONS_INBOX_READ = 'notifications:inbox:read';
	const ACCOUNT_SETTINGS = 'account:settings';
	const USER_VIEW_BASE = 'user:user:base';
	const BILLING_MODULE = 'billing:module';
	const CMS_SEND_COMMENT_NOTIFICATIONS = 'cms:send:comment:notifications';
	const CMS_NOT_SEND_COMMENT_NOTIFICATIONS = 'cms:not:send:comment:notifications';
	const STAT_MODULE = 'stat:module';

	protected static $manualPermissions = [
		self::CMS_MODULE,
		self::NOTIFICATIONS_MODULE,
		self::USER_SURVEY_CONTROLLER,
		self::SALES_OFFER_CONTROLLER,
		self::NOTIFICATIONS_INBOX_READ,
		self::ACCOUNT_SETTINGS,
		self::USER_VIEW_BASE,
		self::BILLING_MODULE,
		self::CMS_SEND_COMMENT_NOTIFICATIONS,
		self::CMS_NOT_SEND_COMMENT_NOTIFICATIONS,
		self::STAT_MODULE
	];

	protected static $manualPermissionLabels = [
		self::CMS_MODULE => 'может управлять cms',
		self::NOTIFICATIONS_MODULE => 'может управлять рассылками',
		self::USER_SURVEY_CONTROLLER => 'может управлять анкетами',
		self::SALES_OFFER_CONTROLLER => 'может управлять предложениями',
		self::NOTIFICATIONS_INBOX_READ => 'может работать с входящими сообщениями',
		self::ACCOUNT_SETTINGS => 'может настраивать аккаунт',
		self::USER_VIEW_BASE => 'может видеть карточку клиента',
		self::BILLING_MODULE => 'может входить в бухгалтерию',
		self::CMS_SEND_COMMENT_NOTIFICATIONS => 'может получать уведомления о комментариях',
		self::CMS_NOT_SEND_COMMENT_NOTIFICATIONS => 'не желает получать уведомления о комментариях',
		self::STAT_MODULE => 'может работать со статистикой (каналы и т.д.)',
	];

	protected static $byNameCache = [];

	public static function tableName()
	{
		return 'user.dynamic_permission';
	}

	/**
	 * @param string $name
	 * @param bool $createIfNotExists
	 * @return self|null
	 * @throws ModelErrorException
	 */
	public static function getByName($name, $createIfNotExists = true)
	{
		if (!isset(self::$byNameCache[$name])) {
			$model = self::find()->where(['name' => $name])->one();
			if (!$model && $createIfNotExists) {
				$model = new self();
				$model->name = $name;
				if (!$model->save()) {
					throw new ModelErrorException($model);
				}
			}
			self::$byNameCache[$name] = $model;
		}

		return self::$byNameCache[$name];
	}

	public static function getManualPermissions()
	{
		$permissions = array_fill_keys(self::$manualPermissions, true);
		$user = \Yii::$app->user;
		if (!($user->isGod() || Account::getInstance()->owner_id == $user->getProfileId())) {
			unset($permissions[self::ACCOUNT_SETTINGS]);
		}
		$isGetcourseSubAccount = Features::getInstance()->isGetcourseSubAccount();
		if (!$isGetcourseSubAccount) {
			unset($permissions[self::STAT_MODULE]);
		}
		if (!$isGetcourseSubAccount || ! \Yii::$app->user->isGod()) {
			unset($permissions[self::BILLING_MODULE]);
		}
		return array_keys($permissions);
	}

	public static function getLabel($permission)
	{
		return isset(self::$manualPermissionLabels[$permission]) ? self::$manualPermissionLabels[$permission] : $permission;
	}

	public static function getUserIds($name)
	{
		$permission = self::getByName($name);
		$ids = DynamicUserPermission::find()->where([
			'permission_id' => $permission->id
		])->select('user_id')->createCommand()->queryColumn();
		return array_map('intval', $ids);
	}
}