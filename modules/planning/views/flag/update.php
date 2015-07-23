<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\planning\models\Flag */

$this->title = Yii::t('planning', 'Update {modelClass}: ', [
    'modelClass' => 'Flag',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('planning', 'Flags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('planning', 'Update');
?>
<div class="flag-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
