<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Результаты поиска';
$this->params['breadcrumbs'][] = 'Результаты поиска';
?>

<?

	echo	GridView::widget([
						'dataProvider' => $providerWords,
						'summary' => false,
						'columns' => [
							['attribute' => 'word',
								'format' => 'raw',
								'label' => 'Слова',
								'options' => ['width' => '13%'],
							],
							['attribute' => 'sum',
								'format' => 'raw',
								'label' => 'Количество на странице',
								'options' => ['width' => '13%'],
							],
						],						
					]);
	echo	GridView::widget([
						'dataProvider' => $providerLinks,
						'summary' => false,
						'columns' => [
							['attribute' => 'link',
								'format' => 'raw',
								'label' => 'Ссылки',
								'options' => ['width' => '13%'],
								'value' =>  function($link) {
									return Html::a($link->link,Url::to($link->link), ['target'=>'_blank']);
								},
							],
						],						
					]);
	echo	GridView::widget([
						'dataProvider' => $providerImages,
						'summary' => false,
						'columns' => [
							['attribute' => 'image_url',
								'format' => 'raw',
								'label' => 'Ссылки на картинки',
								'options' => ['width' => '13%'],
								'value' =>  function($image) {
									return Html::a($image->image_url,Url::to($image->image_url), ['target'=>'_blank']);
								},
							],
						],						
					]);
?>