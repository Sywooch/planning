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

    <?= $form->field($model, 'position_id')->widget(Select2::className(), [
        'data'=>ArrayHelper::map(Position::find()->all(), 'id', 'position'),
        'options'=>['placeholder'=>Yii::t('structure', 'Select a position ...')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'chief')->checkbox() ?>

    <?= $form->field($model, 'email')->input('email') ?>

    <?= $form->field($model, 'department_id')->widget(Select2::className(), [
        'data'=>ArrayHelper::map(Department::find()->asArray()->all(), 'id', 'department'),
        'options' => ['placeholder' => Yii::t('structure', 'Select a department ...')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'logic_delete')->checkbox() ?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <?= $this->render('/phone/addPhones') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
