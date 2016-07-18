<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Задание 1';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id='tableTop'>
	<div class="panel panel-default">
		<div class="panel-heading">
			Найдено <?=$post['sum']?> картинок. <a onclick="showHide('table1')">Показать подробнее</a>
		</div>
		<ul id='table1' hidden class="list-group">
			<li class="list-group-item">Где искали:	<a target="_blank" href="<?=$post['domain']?>"><?=$post['domain']?></a></li>
			<li class="list-group-item">Что искали:	Картинки</li>
			<li class="list-group-item" >Сколько нашли:	<?=$post['sum']?></li>
		</ul>
	</div>
</div>