<?php
/**
 * Created by PhpStorm.
 * User: rzyuzin
 * Date: 09.11.2015
 * Time: 15:49
 */

namespace app\helpers;

use app\components\rbac\models\DynamicPermission;
use app\models\User;
use yii\helpers\Html;

class UserHtml extends Html
{
    public static function userLink(
        $user,
        $part = null,
        $showLink = true,
        $forceAccessCheck = false,
        $newPage = false
    ) {
        return self::userLinkByParams(
            UserLinkParams::create($user)
                ->setPart($part)
                ->setShowLink($showLink)
                ->setForceAccessCheck($forceAccessCheck)
                ->setNewPage($newPage)
        );
    }

    public static function userLinkByParams(UserLinkParams $params)
    {
        list($user,	$part, $showLink, $forceAccessCheck, $newPage) = [
            $params->getUser(),
            $params->getPart(),
            $params->isShowLink(),
            $params->isForceAccessCheck(),
            $params->isNewPage()
        ];
        if (!$user) {
            return "";
        }
        $userId = is_object($user) ? $user->id : $user;

        if (!is_object($user)) {
            $user = User::getUser($userId);
        }

        if (!$user) {
            return 'empty user: ' . $userId;
        }
        $targetBlankHtml = $newPage ? 'target="_blank"' : '';


        $url = \Yii::$app->getHomeUrl().'admin/user/update?id='.$userId;

        return '<a '.$targetBlankHtml.' href="'.$url.'">'.$user->email.'</a>';
    }

    public static function userLinkHref($userId)
    {
        return \Yii::$app->getHomeUrl().'/user/update?id=' . $userId;
    }

    public static function userName($userId)
    {
        $user = User::getUser($userId);
        if (!$user) {
            return "";
        }

        return $user->getFullName();
    }
}