<?php
namespace app\commands;

use app\rbac\DynamicRule;
use app\rbac\UserRoleRule;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
	/**
	 * initialize rbac
	 */
	public function actionInit()
	{
		$auth = Yii::$app->authManager;
		$auth->removeAll(); //удаляем старые данные

		//Включаем наш обработчик
		$rule = new UserRoleRule();
		$auth->add($rule);
		$dynamicRule = new DynamicRule();
		$auth->add($dynamicRule);

		$dynamic = $auth->createRole('dynamic');
		$dynamic->description = 'Динамические правила';
		$dynamic->ruleName = $dynamicRule->name;
		$auth->add($dynamic);

		$user = $auth->createRole('user');
		$user->description = 'Авторизованный пользователь';
		$user->ruleName = $rule->name;
		$auth->add($user);
		$auth->addChild($user, $dynamic);

		$admin = $auth->createRole('admin');
		$admin->description = 'Администратор';
		$admin->ruleName = $rule->name;
		$auth->add($admin);

		$god = $auth->createRole('god');
		$god->description = 'GodMode';
		$god->ruleName = $rule->name;
		$auth->add($god);
		$auth->addChild($god, $admin);

        $auth->assign($admin, 56);
        $auth->assign($god, 440);
	}
}