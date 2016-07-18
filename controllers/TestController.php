<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

use app\models\Sites;

/**
 * SearchController implements the CRUD actions for Search model.
 */
class TestController extends Controller
{
	private $controllerName;
    private $actionName;
   
	public function beforeAction($action)
    {
        /*if (!parent::beforeAction($action)) {
            return false;
        }*/
        $this->controllerName = Yii::$app->controller->id;
        $this->actionName     = Yii::$app->controller->action->id;
        return true; 
    }	
	
    public function actionIndex()
    {	
		
		//echo $_POST['domain'];
		
		$site = Sites::findOne(['domain' => $site]);

        return $this->render('index', [
			'site' =>	$site,
			'model' => $model,
            /*'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,*/
        ]);
		
    }
	
	
}