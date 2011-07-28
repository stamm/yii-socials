<?php
/**
 * 1. Получаем ссылку через getLink()
 * 2. После авторизации в контакте, редиректит на страницу с get-параметром code
 * 3. Получаем $_GET['code'], получаем access_token через getAccessToken($_GET['code']);
 */
class VkAuth extends SocialClass{
	public $apiId;
	public $secret;
	public $redirectUri;
	public $settings;
	public $scope;


	public function init()
	{
		$this->redirectUri = Yii::app()->createAbsoluteUrl($this->redirectUri);
	}

	public function getLink() {
		return 'https://api.vk.com/oauth/authorize?client_id=' . $this->apiId . '&scope=' . $this->settings . '&redirect_uri=' . $this->redirectUri . '&scope=' . $this->scope . '&response_type=code';
	}

	/**
	 * Получаем access_token и id пользователя
	 * @throws CException
	 * @param $code
	 * @return array
	 */
	public function getAccessToken($code)
	{
		try
		{
			echo $url = 'https://api.vk.com/oauth/access_token?client_id=' . $this->apiId . '&client_secret=' . $this->secret . '&code=' . $code;
			$sJson = $this->getPage($url);
			if ( ! $sJson)
			{
				$this->_errors[] = 'not get access_token';
				throw new CException(__CLASS__ . ' not get access_token');
			}
			$aJson = json_decode($sJson, true);
			if ( ! empty($aJson['error']))
			{
				$this->_errors[] = 'error: ' . @$aJson['error_description'];
				throw new CException('VK:' . @$aJson['error_description']);
			}
			return $aJson;
		} catch (Exception $e){
			return false;
		}
	}

	public function call($method, $parameters, $accessToken)
	{
		$sJson = $this->getPage('https://api.vk.com/method/' . $method . '?' . http_build_query($parameters) . '&access_token=' . $accessToken);
		$aJson = json_decode($sJson);
		return $aJson;
	}

}