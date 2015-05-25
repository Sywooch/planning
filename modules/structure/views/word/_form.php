<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\structure\models\Word */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="word-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'word')->textInput(['maxlength' => true])->hint('Введите слово-помощник или перечислите несколько через запятую.') ?>

    <?= $form->field($model, 'type')->widget(Select2::className(), [
        'data' => \app\modules\structure\models\Word::getTypes(),
        'options' => ['placeholder' => Yii::t('app', 'Select type...')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
