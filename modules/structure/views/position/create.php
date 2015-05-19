<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\structure\models\Position */

$this->title = Yii::t('structure', 'Create position');
$this->params['breadcrumbs'][] = ['label' => Yii::t('structure', 'Positions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
