<?php
/**
 * Created by PhpStorm.
 * User: rzyuzin
 * Date: 09.11.2015
 * Time: 15:51
 */

namespace app\helpers;


class UserLinkParams
{
    protected $user;
    protected $part = null;
    protected $showLink = true;
    protected $forceAccessCheck = false;
    protected $newPage = false;
    protected $onlyProfileLink = false;

    public static function create($user)
    {
        return new self($user);
    }

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * @param null $part
     * @return UserLinkParams
     */
    public function setPart($part)
    {
        $this->part = $part;
        return $this;
    }

    /**
     * @param boolean $showLink
     * @return UserLinkParams
     */
    public function setShowLink($showLink)
    {
        $this->showLink = $showLink;
        return $this;
    }

    /**
     * @param boolean $forceAccessCheck
     * @return UserLinkParams
     */
    public function setForceAccessCheck($forceAccessCheck)
    {
        $this->forceAccessCheck = $forceAccessCheck;
        return $this;
    }

    /**
     * @param boolean $newPage
     * @return UserLinkParams
     */
    public function setNewPage($newPage)
    {
        $this->newPage = $newPage;
        return $this;
    }

    /**
     * @param boolean $onlyProfileLink
     * @return UserLinkParams
     */
    public function setOnlyProfileLink($onlyProfileLink)
    {
        $this->onlyProfileLink = $onlyProfileLink;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return null
     */
    public function getPart()
    {
        return $this->part;
    }

    /**
     * @return boolean
     */
    public function isShowLink()
    {
        return $this->showLink;
    }

    /**
     * @return boolean
     */
    public function isForceAccessCheck()
    {
        return $this->forceAccessCheck;
    }

    /**
     * @return boolean
     */
    public function isNewPage()
    {
        return $this->newPage;
    }

    /**
     * @return boolean
     */
    public function isOnlyProfileLink()
    {
        return $this->onlyProfileLink;
    }
}