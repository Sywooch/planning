<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\structure\models\Position */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
    $this->registerJs(
    'jQuery("#new-position").on("pjax:end", function() {
            jQuery.pjax.reload({container:"#positions-grid"});
        });'
    );
?>

<div class="position-form">
    <?php Pjax::begin(['id' => 'new-position', 'enablePushState'=>false]) ?>
        <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>

        <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Add') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    <?php Pjax::end() ?>

</div>
