<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\structure\models\Word */

$this->title = Yii::t('structure', 'Create word');
$this->params['breadcrumbs'][] = ['label' => Yii::t('structure', 'Words'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="word-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
