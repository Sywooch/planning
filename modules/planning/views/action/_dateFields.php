<?php
/* @var $form \yii\widgets\ActiveForm*/
/* @var $model \app\modules\planning\models\Action */

use kartik\widgets\DateTimePicker;
?>
<?= $form->field($model, 'dateStart')->widget(DateTimePicker::className(), [
    'options' => ['placeholder' => Yii::t('planning', 'Enter start time ...')],
    'pluginOptions' => [
        'format' => 'dd.mm.yyyy hh:ii',
        'autoclose'=>true,
    ]
]) ?>

<?= $form->field($model, 'dateStop')->widget(DateTimePicker::className(), [
    'options' => ['placeholder' => Yii::t('planning', 'Enter stop time ...')],
    'pluginOptions' => [
        'format' => 'dd.mm.yyyy hh:ii',
        'autoclose'=>true,
    ]
]) ?>