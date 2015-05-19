<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\structure\models\Employee */

$this->title = Yii::t('structure', 'Create employee');
$this->params['breadcrumbs'][] = ['label' => Yii::t('structure', 'Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
