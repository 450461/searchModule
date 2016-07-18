<?php


use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Результаты поиска';
$this->params['breadcrumbs'][] = 'Результаты поиска';
?>

<div class="col-md-4" >
	<?= GridView::widget([
						'dataProvider' => $provider,
						'summary' => false,
						'columns' => [
							['attribute' => 'domain',
								'format' => 'raw',
								'label' => 'Найденные сайты',
								'options' => ['width' => '13%'],
								'value' =>  function($site) {
									return Html::a($site->domain,Url::to('#'),['onclick'=>"showSaved($site->id)"]);
								},
							],
						],
					]);
	?>
</div>
<div class="col-md-8">
	<div id='saved'>
	</div>
</div>