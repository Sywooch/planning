<?php

use kartik\widgets\Select2;
use app\modules\structure\models\Department;
use \app\modules\structure\models\Position;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\structure\models\Employee */
/* @var $form yii\widgets\ActiveForm */
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

</div>
