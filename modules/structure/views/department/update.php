<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\structure\models\Department */

$this->title = Yii::t('structure', 'Update department: ') . ' ' . $model->department;
$this->params['breadcrumbs'][] = ['label' => Yii::t('structure', 'Departments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->department, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('structure', 'Update');
?>
<div class="department-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
