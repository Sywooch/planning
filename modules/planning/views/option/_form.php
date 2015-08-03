<?php

use kartik\time\TimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\planning\models\Option */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs(
'jQuery("#new-option").on("pjax:end", function() {
    jQuery.pjax.reload({container:"#option-grid"});
});'
);
?>

<div class="option-form">
    <?php Pjax::begin(['id' => 'new-option', 'enablePushState' => false]) ?>
        <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'option')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-sm-6">
                <?= $form->field($model, 'duration')->widget(TimePicker::className(),[
                    'pluginOptions' => [
                        'showMeridian' => false,
                        'minuteStep' => 5,
                        'defaultTime' => '00:00',
                    ]
                ]) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Add') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    <?php Pjax::end() ?>
</div>
