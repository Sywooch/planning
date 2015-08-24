<?php

use kartik\helpers\Html as HtmlKart;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\planning\models\Place */

$this->title = $model->place;
$this->params['breadcrumbs'][] = ['label' => Yii::t('planning', 'Places'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="place-view">

    <h1>
        <?= Html::encode($this->title) ?>
        <?= Html::a(HtmlKart::icon('pencil'), ['update', 'id' => $model->id]) //['class' => 'btn btn-primary'] ?>
        <?= Html::a(HtmlKart::icon('trash'), ['delete', 'id' => $model->id], [
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])?>
    </h1>
</div>
