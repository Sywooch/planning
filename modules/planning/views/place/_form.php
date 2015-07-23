<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\planning\models\Place */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs(
    'jQuery("#new-place").on("pjax:end", function() {
        jQuery.pjax.reload({container:"#place-grid"});
    });'
);
?>

<div class="place-form">
    <?php Pjax::begin(['id' => 'new-place', 'enablePushState' => false]) ?>
        <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>

        <?= $form->field($model, 'place')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Add') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    <?php Pjax::end() ?>

</div>
