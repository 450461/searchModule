<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * SearchController implements the CRUD actions for Search model.
 */
class Task3Controller extends Controller
{
	private $controllerName;
    private $actionName;

	public function beforeAction($action)
    {
        $this->controllerName = Yii::$app->controller->id;
        $this->actionName     = Yii::$app->controller->action->id;
        return true;
    }

    public function actionIndex()
    {
		//создаю код xml файла и заношу его в переменную $xml
		$dom = new \DOMDocument( "1.0", "UTF-8" );
		$request = $dom->appendChild($dom->createElement('request'));
		$action = $request->appendChild($dom->createElement('action'));
		$action->appendChild($dom->createTextNode('get_currency_rates'));
		$dom->formatOutput = true;
		$xml = $dom->saveXML();

		$url = "";	//ссылка убрана ))
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "xml=" . $xml);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);
		curl_close($ch);
		$array_data = json_decode(json_encode(simplexml_load_string($data)), true);

        return $this->render('index', [
			'model' => $model,
			'data' => $array_data['currency'],
        ]);
    }
}