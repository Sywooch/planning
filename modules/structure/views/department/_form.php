<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\structure\models\Department;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\structure\models\Department */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs(
    'jQuery("#new-department").on("pjax:end", function() {
        jQuery.pjax.reload({container:"#department-grid"});
    });'
);
?>

<div class="department-form">
    <?php Pjax::begin(['id' => 'new-department']) ?>
        <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>

        <?= $form->field($model, 'department')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'department_id')->widget(Select2::className() ,[
            'data'=> ArrayHelper::map(Department::find()->asArray()->all(), 'id', 'department'),
            'options' => ['placeholder' => Yii::t('structure', 'Select a department ...')],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Add') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>
