<?php
	
namespace app\components\help;

use Yii;
use yii\helpers\Html;
 
class validURL
{
	private static function checkwww($path){
		//убираю www если есть, для исключения дублирования в бд
		return preg_replace('#^www.#', '', $path);
	}

    private static function  parseURL($url)
	{
		//разбиваю полученный URL в массив
		$urlArr = parse_url($url);
		//если в ссылке не был указан http://
		if (!array_key_exists("scheme", $urlArr) || !in_array($urlArr["scheme"], array("http", "https")))
		{
			$urlArr = [
						'scheme' => 'http',
						'host'	=>	$urlArr['path'],
						];	
		}
		$urlArr['host'] = self::checkwww($urlArr['host']);
		//проверяю на правильность имени хоста
		if (preg_match("/^\w+\.[\w\.]+(\/.*)?$/", $urlArr['host'])){
			return $urlArr['scheme'].'://'.$urlArr['host'];	//если все нормально вовзаращаю полную ссылку
		}else{
			return false;
		}
	}

	private static function pingUrl($url){
		//проверяю на существование сайта
		try {
			$headers = get_headers($url);
		}catch(\Exception $e){
			  return false;
		}
		return true;	
	}

	public static function checkUrl($url)
	{
		if (!empty($url)) {
			$url = self::parseURL($url);
			if (self::pingUrl($url)){
				return $url;	//возвращаю url если сайт правильно запоkyty и существует в сети
			}else{
				return false;
			}
		}
	}
}