<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\planning\models\Option */

$this->title = Yii::t('planning', 'Create option');
$this->params['breadcrumbs'][] = ['label' => Yii::t('planning', 'Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="option-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
