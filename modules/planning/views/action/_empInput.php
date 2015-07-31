<?php
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\planning\models\Action */
/* @var $attribute string */
/* @var $this \yii\web\View*/

use app\modules\structure\models\Experience;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;

$val = (new ReflectionClass('app\modules\planning\models\Action'))->getProperty($attribute)->getValue($model);

echo $form->field($model, $attribute)->widget(Select2::className(), [
    'options' => ['placeholder' => Yii::t('structure', 'Search a employee ...')],
    'initValueText' => Experience::getEmpFioByExp($val),
    'pluginOptions' => [
        'multiple' => true,
        'allowClear' => true,
        'minimumInputLength' => 3,
        'ajax' => [
            'url' => Url::to(['/structure/experience/employee-list']),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        'templateResult' => new JsExpression('function(empIDs) { return empIDs.full; }'),
        'templateSelection' => new JsExpression('function (empIDs) {  return empIDs.text; }'),
    ],
]);
