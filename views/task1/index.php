<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Dropdownlist;

use app\models\Sites;

$this->title = 'Задание1';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-4" >

	<div class="form-group" >
		<label form="text">На каком сайте?</label>
		<input type="text"	required autofocus onChange="show('search')"
				id='domain' class="form-control" placeholder="Введите домен сайта, например mail.ru" value=''/>
	</div>

	<div class="form-group" >
		<label form="select">Что будем искать?</label>
			<select  onChange="checkSelect()" class="form-control" id='search'>
			<option selected disabled>Выберите предмет поиска</option>
			<option value = "query">Поиск слова</option>
			<option value = "link">Поиск ссылок</option>
			<option value = "image">Поиск картинок</option>
			</select>
	</div>

	<div class="form-group" >
		<label form="text">Что ищем?</label>
		<input type="text" disabled	required
				onChange="show('submit')"
				 id='word' class="form-control" name="word" placeholder="Слово для поиска" value=''/>
	</div>
	<br>
	<button onClick='sendUpdate()' disabled type="submit"  id='submit' class="btn btn-default">Найти</button>

</div>

<div class="col-md-8" >
	<div id='tableTop'>
	</div>
</div>