<?php

use app\modules\structure\EmployeeFormAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\structure\models\Employee */
/* @var $form yii\widgets\ActiveForm */
/* @var $dataProvider \yii\data\ActiveDataProvider */
EmployeeFormAsset::register($this);
?>

<div class="employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->input('email') ?>

    <?= $form->field($model, 'logic_delete')->checkbox() ?>

    <h3>Стаж на момент приема на работу</h3>
    <div class="row">
        <div class="vcenter col-sm-3"><h4>Общий стаж</h4></div>
        <div class="vcenter col-sm-2"><?= $form->field($model, '_d')->textInput(['maxlength' => 2])->label('Дней') ?></div>
        <div class="vcenter col-sm-2"><?= $form->field($model, '_m')->textInput(['maxlength' => 2])->label('Месяцев') ?></div>
        <div class="vcenter col-sm-2"><?= $form->field($model, '_y')->textInput(['maxlength' => 2])->label('Лет') ?></div>
    </div>

    <div class="row">
        <div class="vcenter col-sm-3"><h4>Муниципальный стаж</h4></div>
        <div class="vcenter col-sm-2"><?= $form->field($model, '_md')->textInput(['maxlength' => 2])->label('Дней') ?></div>
        <div class="vcenter col-sm-2"><?= $form->field($model, '_mm')->textInput(['maxlength' => 2])->label('Месяцев') ?></div>
        <div class="vcenter col-sm-2"><?= $form->field($model, '_my')->textInput(['maxlength' => 2])->label('Лет') ?></div>
    </div>

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
</div>
