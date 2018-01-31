<?php
namespace app\helpers;

class ImageThumbnail
{
	const DEFAULT_SCHEME = '//';
	const GLOBAL_USER_PROFILE_URL = "/public/img/gc_user_50.png";
	const DEFAULT_USER_PROFILE_URL = "/public/img/default_profile_50.png";
	const DEFAULT_USER_PROFILE_BIG_URL = "/public/img/default_profile_300.png";

	protected $user;
	protected $class = "";
	protected $width = 50;
	protected $height = 50;
	protected $convertToLetter = false;
	protected $scheme = self::DEFAULT_SCHEME;

	protected $colors = [
		'#FF66FF', '#FF6699', '#FF6633', '#FF33CC', '#FF3366', '#FF3300', '#FF00CC', '#FF0000', '#FFCCCC', '#FFCC33',
		'#CC99CC', '#CCCC66', '#CC66CC', '#CC6666', '#CC0066', '#99CCCC', '#996699', '#999933', '#996699', '#990066',
		'#66CCCC', '#669966', '#666699', '#663399', '#666633', '#660000', '#00CC99', '#009966', '#003300', '#006699',
		'#003333', '#000066', '#333333', '#339999', '#3399FF', '#9900FF', '#666600', '#FFCC00', '#006600', '#6600CC'
	];

	public function __construct($user, $class = "", $width = 50, $height = 50, $convertToLetter = false)
	{
		$this->user = $user;
		$this->class = $class;
		$this->width = $width;
		$this->height = $height;
		$this->convertToLetter = $convertToLetter;
	}

	public static function create($userId, $class = "", $width = 50, $height = 50, $convertToLetter = false)
	{
		return new static($userId, $class, $width, $height, $convertToLetter);
	}

	public function render()
	{
		$userId = is_object( $this->user ) ? $this->user->id : $this->user;
		if ($userId == User::GOD_USER_ID) {
			return "<img width='$this->width' class='user-profile-image $this->class' src='" . $this->getImageUrl(self::GLOBAL_USER_PROFILE_URL) . "'>";
		}

		$user = $this->user;
		if ( ! is_object( $user ) ) {
			$user = Yii1To2::getUser($userId);
		}

		if (!$user || !$user->getProfileImage() || getConfig('is_local')) {
			return $this->renderEmpty();
		} else {
			$thumbnailUrl = FileService::getInstance()->getThumbnailUrl($user->getProfileImage(), $this->width, $this->height);
			$thumbnailUrl = preg_match('#^//#i', $thumbnailUrl) ?
				$this->scheme.preg_replace('#^//#i', '', $thumbnailUrl) :
				$thumbnailUrl; // todo хачина
			return "<img width='$this->width' class='user-profile-image $this->class' src='" . $thumbnailUrl . "'>";
		}
	}

	/**
	 * @param string $class
	 */
	public function setClass($class)
	{
		$this->class = $class;
		return $this;
	}

	/**
	 * @param int $width
	 */
	public function setWidth($width)
	{
		$this->width = $width;
		return $this;
	}

	/**
	 * @param int $height
	 */
	public function setHeight($height)
	{
		$this->height = $height;
		return $this;
	}

	/**
	 * @return string
	 */
	protected function renderEmpty()
	{
		if ($this->convertToLetter)	{
			$userId = is_object( $this->user ) ? $this->user->id : $this->user;
			$user = $this->user;
			if ( ! is_object( $user ) ) {
				$user = Yii1To2::getUser($userId);
			}
			$style = [
				'width:'.$this->width.'px;',
				'height:'.$this->height.'px;',
				'font-size:'.round($this->height * .8).'px;',
				'line-height:'.$this->height.'px;'
			];
			$color = $userId % count($this->colors);
			$style[] = 'background-color:'.$this->colors[$color];
			return '<span class="user-profile-letter" style="'.join('', $style).'">'.mb_substr(mb_strtoupper( $user->getName(), "UTF-8" ), 0, 1, "UTF-8").'</span>';
		} else {
			return "<img width='$this->width' class='user-profile-image user-default-profile-image $this->class' src='" . $this->getImageUrl($this->getDefaultProfileUrl()) . "'>";
		}
	}
	
	public static function widget($userId, $class = "", $width = 50, $height = 50, $convertToLetter = false)
	{
		return static::create($userId, $class, $width, $height, $convertToLetter)->render();
	}

	/**
	 * @return string
	 */
	protected function getDefaultProfileUrl()
	{
		return 50 >= $this->width ? self::DEFAULT_USER_PROFILE_URL : self::DEFAULT_USER_PROFILE_BIG_URL;
	}

	/**
	 * @param mixed $scheme
	 */
	public function setScheme($scheme)
	{
		$this->scheme = $scheme;
		return $this;
	}


	protected function getImageUrl($imageUrlWithoutHost)
	{
		return $this->scheme.getConfig('root_host').$imageUrlWithoutHost;// todo уйти от завязки на домен
	}
}