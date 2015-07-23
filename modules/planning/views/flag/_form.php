<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\planning\models\Flag */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs(
    'jQuery("#new-flag").on("pjax:end", function() {
        jQuery.pjax.reload({container:"#flag-grid"});
    });'
);
?>

<div class="flag-form">

    <?php Pjax::begin(['id' => 'new-flag', 'enablePushState' => false]); ?>
        <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'icon')->textInput(['maxlength' => true])
            ->hint(Yii::t('planning', 'Type here <a href="http://fontawesome.io/icons/" target="_blank">FontAwesome</a> icon name.')) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Add') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>

</div>
