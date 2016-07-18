<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

use app\models\Sites;
use app\models\Words;
use app\models\Links;
use app\models\Images;

/**
 * SearchController implements the CRUD actions for Search model.
 */
class Task1Controller extends Controller
{
	private $controllerName;
    private $actionName;
	private $domain;	//для хранения названия домена из $_POST
	const ERR_URL = 'Указанный вами сайт не существует или имя домена введено не верно.';

	public function beforeAction($action)
    {
        $this->controllerName = Yii::$app->controller->id;
        $this->actionName     = Yii::$app->controller->action->id;
		$this->domain = Yii::$app->request->post('domain');
        return true;
    }

    public function actionIndex()
    {
		$site = Sites::findOne(['domain' => $site]);
        return $this->render($this->actionName, [
			'site' =>	$site,
			'model' => $model,
        ]);
    }

	public function actionQuery()	//search words
	{
		$word = Yii::$app->request->post('word');	//словосочетание из $_POST
		//$searchArr массив для адреса сайта и слова для поиска
		$searchArr['domain'] = Yii::$app->help->checkUrl($this->domain);
		/*с помощью компонента /components/help/validURL.php проверяю получаемый url на
			правильность заполнения домена сайта и на существование этого сайта в сети*/
		if ($searchArr['domain'] && !empty($word))
		{
			$searchArr['word'] = $word;
			$file = file_get_contents($searchArr['domain']);
			$searchArr['sum'] = preg_match_all("-".$searchArr['word']."-",  $file);	//ищем слово, колчиество найденных заносим в переменную

			if ($searchArr['sum']){	//если слова нашлись подключаем ся к базе и:
				$connection = Yii::$app->db;
				$site = Sites::findOne(['domain' => $searchArr['domain']]);	//ищем в таблице базы текущий сайт
				if (!$site->id){
					// если сайта нету в бд, добавляем
					$connection->createCommand()->insert('sites', ['domain' => $searchArr['domain']])->execute();
					$siteID = Yii::$app->db->lastInsertID;
				}else{
					//если есть, берем его ID
					$siteID = $site->id;
				}				//пишем найденное в базу
				$connection->createCommand()->insert(
							'words',['word' => $searchArr['word'], 'sum' => $searchArr['sum'],'ext_id' => $siteID]
							)->execute();
			}
		}else{	//если сайт не существует или неверно заполнено имя домена сообщаем об этом
			die (self::ERR_URL);
		}
		return $this->renderPartial($this->actionName,[
			'post' => $searchArr,	//потом буду использовать в Виде
		]);
	}

	public function actionLink()	//search links
	{
		$searchArr['domain'] = Yii::$app->help->checkUrl($this->domain);
		if ($searchArr['domain'])
		{
			$html = file_get_contents($searchArr['domain']);
			//обнаруживаю ссылки
			$searchArr['sum'] = preg_match_all("/<[Aa][\s]{1}[^>]*[Hh][Rr][Ee][Ff][^=]*=[ '\"\s]*([^ \"'>\s#]+)[^>]*>/", $html, $matches);
			$urls = $matches[1];	//беру url ссылок
			if ($urls)
			{
				$connection = Yii::$app->db;
				$site = Sites::findOne(['domain' => $searchArr['domain']]);
				if (!$site->id)
				{
					$connection->createCommand()->insert('sites', ['domain' => $searchArr['domain']])->execute();
					$siteID = Yii::$app->db->lastInsertID;
				}else{
					$siteID = $site->id;
				}
				foreach ($urls as $url){
					$arr = parse_url($url);
					if (!array_key_exists('scheme', $arr))
					{	//если оказалась ссылка без имени домена добавляю домен
						$url = $searchArr['domain'].$url;
					}
					$connection->createCommand()->insert(	//сохраняю в базу
								'links', (['link' => $url, 'ext_id' => $siteID])
								)->execute();
				}
			}
		}else{
			die (self::ERR_URL);
		}
		return $this->renderPartial($this->actionName,[
			'post' => $searchArr,
		]);
	}

	public function actionImage()	//search images
	{
		$searchArr['domain'] = Yii::$app->help->checkUrl($this->domain);
		if ($searchArr['domain'])
		{
			$html = file_get_contents($searchArr['domain']);
			$searchArr['sum'] = preg_match_all('/<img(?:\\s[^<>]*?)?\\bsrc\\s*=\\s*(?|"([^"]*)"|\'([^\']*)\'|([^<>\'"\\s]*))[^<>]*>/i', $html, $result);
			$urls = $result[1];	//беру url картинок

			if ($urls)
			{
				$connection = Yii::$app->db;
				$site = Sites::findOne(['domain' => $searchArr['domain']]);
				if (!$site->id)
				{
					$connection->createCommand()->insert('sites', ['domain' => $searchArr['domain']])->execute();
					$siteID = Yii::$app->db->lastInsertID;
				}else{
					$siteID = $site->id;
				}
				foreach ($urls as $img){
					$arr = parse_url($img);
					if (!array_key_exists('scheme', $arr)){
						$img = $searchArr['domain'].$img;
					}
					$connection->createCommand()->insert(
									'images', (['image_url' => $img, 'ext_id' => $siteID])
									)->execute();
				}
			}
		}else{
			die (self::ERR_URL);
		}
		return $this->renderPartial($this->actionName,[
			'post' => $searchArr,
		]);
	}

	public function actionResult()
    {
        $query = Sites::find();
		//данные для отображения найденных сайтов через GridView в Виде
		$provider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => false,
		]);

        return  $this->render($this->actionName,[
			'provider' => $provider,
		]);
    }
	public function actionGetsaved()
	{
		//данные для отображения всего найденного по конкретному сайту в Виде, через GridView
		$siteID = Yii::$app->request->post('id');
		$queryWords = Words::find()->where(['ext_id' =>$siteID]);
		$providerWords = new ActiveDataProvider([
			'query' => $queryWords,
			'pagination' => false,
		]);

		$queryLinks = Links::find()->where(['ext_id' =>$siteID]);
		$providerLinks = new ActiveDataProvider([
			'query' => $queryLinks,
			'pagination' => false,
		]);
		$queryImages = Images::find()->where(['ext_id' =>$siteID]);
		$providerImages = new ActiveDataProvider([
			'query' => $queryImages,
			'pagination' => false,
		]);

		return $this->renderPartial($this->actionName,[
			'providerWords' => $providerWords,
			'providerLinks' => $providerLinks,
			'providerImages' => $providerImages,
		]);
	}
}