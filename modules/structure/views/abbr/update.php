<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\structure\models\Abbr */

$this->title = Yii::t('structure', 'Update {modelClass}: ', [
    'modelClass' => 'Abbr',
]) . ' ' . $model->abbr;
$this->params['breadcrumbs'][] = ['label' => Yii::t('structure', 'Abbrs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->abbr, 'url' => ['view', 'id' => $model->abbr]];
$this->params['breadcrumbs'][] = Yii::t('structure', 'Update');
?>
<div class="abbr-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
