<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\structure\models\StaffList */

$this->title = Yii::t('structure', 'Update staff unit: ') . ' ' . $model->department_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('structure', 'Staff list'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->department_id, 'url' => ['view', 'department_id' => $model->department_id, 'position_id' => $model->position_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="staff-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
