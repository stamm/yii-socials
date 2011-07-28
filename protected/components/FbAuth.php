<?php
/**
 * 1. Получаем ссылку через getLink()
 * 2. После авторизации в контакте, редиректит на страницу с get-параметром code
 * 3. Получаем $_GET['code'], получаем access_token через getAccessToken($_GET['code']);
 */
class FbAuth extends SocialClass{
	public $appId;
	public $secret;
	public $redirectUri;
	public $settings;
	public $scope;

	private $_fb;


	public function init()
	{
		$this->redirectUri = Yii::app()->createAbsoluteUrl($this->redirectUri);
		$this->_fb = new facebook(array(
			'appId'  => $this->appId,
			'secret' => $this->secret,
		));
	}

	public function getLink() {
		return $this->_fb->getLoginUrl(array(
			'redirect_uri' . $this->redirectUri
		));
	}

	public function getData() {
		$user = $this->_fb->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $this->_fb->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
	return false;
  }
	return $user_profile;
}
	}
}