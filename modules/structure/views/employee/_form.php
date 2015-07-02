<?php

use app\modules\structure\EmployeeFormAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\structure\models\Employee */
/* @var $form yii\widgets\ActiveForm */
EmployeeFormAsset::register($this);
?>

<div class="employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->input('email') ?>

    <?= $form->field($model, 'logic_delete')->checkbox() ?>

    <?php if(!empty($model->phones))
    {
        foreach($model->phones as $phone)
        {
            echo Html::beginTag('div',['class'=>'phone']);
            echo $this->render('/phone/_phone', ['phone'=>$phone]);
            echo Html::endTag('div');
        }
    }?>

    <?= $this->render('/phone/addPhones', ['model'=>$model]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?= $this->render('_addWorkForm', ['model' => new \app\modules\structure\models\Experience(['employee_id'=>$model->id])]) ?>
    <?php Pjax::begin(['id' => 'emp-works']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'start:date',
            'stop:date',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
