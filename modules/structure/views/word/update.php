<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\structure\models\Word */

$this->title = Yii::t('structure', 'Update word: ') . ' ' . $model->word;
$this->params['breadcrumbs'][] = ['label' => Yii::t('structure', 'Words'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->word, 'url' => ['view', 'id' => $model->word]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="word-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
