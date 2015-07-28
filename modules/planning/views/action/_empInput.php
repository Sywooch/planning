<?php
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\planning\models\Action */
/* @var $varName string */

use kartik\select2\Select2;
use yii\web\JsExpression;

echo $form->field($model, $varName)->widget(Select2::className(), [
//        'initValueText' => $cityDesc, // set the initial display text
'options' => ['placeholder' => Yii::t('structure', 'Search a employee ...'), 'multiple' => true],
'pluginOptions' => [
    'allowClear' => true,
    'minimumInputLength' => 3,
    'ajax' => [
        'url' => \yii\helpers\Url::to(['/structure/employee/employee-list']),
        'dataType' => 'json',
        'data' => new JsExpression('function(params) { return {q:params.term}; }')
    ],
    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
    'templateResult' => new JsExpression('function(placesIDS) { return placesIDS.full; }'),
    'templateSelection' => new JsExpression('function (placesIDS) {  return placesIDS.fio; }'),
],
]);