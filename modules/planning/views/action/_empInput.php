<?php
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\planning\models\Action */
/* @var $varName string */
/* @var $this \yii\web\View*/

use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;

$url = Url::to(['/structure/experience/employee-by-exp']);
$initScript = <<<JS
    function(element, callback) {
                var id=$(element).val();
                if (id !== "") {
                    $.ajax("{$url}?id=" + id, {
                        dataType: "json"
                    }).done(function(data) { callback(data.results);});
                }
            }
JS;
//$val = (new ReflectionClass('app\modules\planning\models\Action'))->getProperty($varName)->getValue($model);

echo $form->field($model, $varName)->widget(Select2::className(), [
    'options' => ['placeholder' => Yii::t('structure', 'Search a employee ...')],
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
        'templateResult' => new JsExpression('function(placesIDS) { return placesIDS.full; }'),
        'templateSelection' => new JsExpression('function (placesIDS) {  return placesIDS.fio; }'),
        'initSelection' => new JsExpression($initScript)
    ],
]);