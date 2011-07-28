<?php
class SocialClass
{
	protected $_errors = array();
	protected function getPage($url)
	{
		$ch = curl_init();

		// установка URL и других необходимых параметров
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// загрузка страницы и выдача её браузеру
		$ret = curl_exec($ch);

		// завершение сеанса и освобождение ресурсов
		curl_close($ch);
		return $ret;
	}
	
	public function getErrors()
	{
		return $this->_errors;
	}
}