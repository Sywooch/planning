<?php

use kartik\widgets\DateTimePicker;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\planning\models\Action */

$this->title = $model->action;
$this->params['breadcrumbs'][] = ['label' => Yii::t('planning', 'Actions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="action-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('planning', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::tag('button', Yii::t('planning', 'Transfer'), ['class' => 'btn btn-default', 'data-toggle' => 'modal', 'data-target' => '#transfer-modal']) ?>
    </p>

    <?php
    Modal::begin([
        'id' => 'transfer-modal',
        'header' => '<h3>'.Yii::t('planning', 'Transferring action').'</h3>',
    ]);
    ?>
        <div class="transfer-form">
            <?php $form = ActiveForm::begin([
                'action' => Url::toRoute(['/planning/action/transfer', 'id' => $model->id]),
                'method' => 'post'
            ]) ?>

            <label class="control-label"></label>
            <?= DateTimePicker::widget([
                'name' => 'old_start',
                'value' => date('d.m.Y H:i', strtotime('+1 day')),
                'options' => ['placeholder' => 'Select operating time ...'],
                'pluginOptions' => [
                    'format' => 'dd.mm.yyyy hh:ii',
                    'autoclose'=>true,
                ]
            ]) ?>

            <?= DateTimePicker::widget([
                'name' => 'old_stop',
                'value' => date('d.m.Y H:i', strtotime('+1 day 30 minutes')),
                'options' => ['placeholder' => 'Select operating time ...'],
                'pluginOptions' => [
                    'format' => 'dd.mm.yyyy hh:ii',
                    'autoclose'=>true,
                ]
            ]) ?>

            <?php ActiveForm::end() ?>
        </div>
    <?php Modal::end();?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'dateStart',
            'dateStop',
            [
                'label' => Yii::t('planning', 'Category'),
                'value' => ($model->isMonth())?$model->category->name:'',
                'visible' => $model->isMonth()
            ]
            ,
//            'action:ntext',
            [
                'label' => Yii::t('planning', 'Author'),
                'value' => $model->author->username,
            ],
//            'week_status',
//            'confirmed',
//            'created_at',
//            'updated_at',
//            'month_status',
//            'month',
//            'week',
            'template',
            'repeat',
        ],
    ]) ?>

</div>
