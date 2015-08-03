<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\planning\models\Option */

$this->title = Yii::t('planning', 'Update option:') . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('planning', 'Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="option-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
