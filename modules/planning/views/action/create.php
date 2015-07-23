<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\planning\models\Action */

$this->title = Yii::t('planning', 'Create action');
$this->params['breadcrumbs'][] = ['label' => Yii::t('planning', 'Actions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="action-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
