<?php

use kartik\helpers\Html as HtmlKart;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\structure\models\Employee */

$this->title = $model->fio;
if( $model->department !== null){
    $this->params['breadcrumbs'][] = ['label' => Yii::t('structure', 'Departments'), 'url' => ['department/index']];
    $this->params['breadcrumbs'][] = ['label' => Html::encode($model->department->department), 'url' => ['department/view', 'id' => $model->department->id]];
}
else {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('structure', 'Employees'), 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-view">

    <h1>
        <?= Html::encode($this->title) ?>
        <?= Html::a(HtmlKart::icon('pencil'), ['update', 'id' => $model->id]) //['class' => 'btn btn-primary'] ?>
        <?= Html::a(HtmlKart::icon('trash'), ['delete', 'id' => $model->id], [
            'data' => [
                'confirm' => Yii::t('structure', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])?>
    </h1>
    <?php if ($model->department !== null): ?>
        <h4><?= $model->position .' '. Html::encode($model->department->getDepartmentGenitive()) ?></h4>
    <?php endif; ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'fio',
            'email:email',
            'logic_delete:boolean',
            [
                'label' => Yii::t('structure', 'Phones'),
                'value' => implode(', ', $model->phones),
            ]
        ],
    ]) ?>

    <?= $this->render('/experience/create', [
        'model' => new \app\modules\structure\models\Experience(['employee_id' => $model->id]),
        'dataProvider' => new \yii\data\ActiveDataProvider(['query' => $model->getExtendedExperience()])
    ]) ?>

</div>
