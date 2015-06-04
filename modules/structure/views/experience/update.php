<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\structure\models\Experience */

$this->title = Yii::t('structure', 'Update {modelClass}: ', [
    'modelClass' => 'Experience',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('structure', 'Experiences'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('structure', 'Update');
?>
<div class="experience-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
