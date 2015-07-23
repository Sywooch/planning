<?php

use app\modules\planning\models\Category;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\modules\planning\models\Action */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="action-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dateStart')->widget(DateTimePicker::className()) ?>

    <?= $form->field($model, 'dateStop')->widget(DateTimePicker::className()) ?>

    <?= $form->field($model, 'category_id')
        ->dropDownList(
            ArrayHelper::map(Category::find()->asArray()->all(), 'id', 'name'),
            ['prompt' => Yii::t('planning', 'Select a category ...')]
        ) ?>

    <?= $form->field($model, 'flagsAdd')->checkboxList(
        ArrayHelper::map(\app\modules\planning\models\Flag::find()->asArray()->all(), 'id', 'name'),
        ['separator' => '<br/>']
    ) ?>

    <?= $form->field($model, 'placesAdd')->widget(Select2::className(), [
        'data' => ArrayHelper::map(\app\modules\planning\models\Place::find()->all(), 'id', 'place'),
        'options' => ['placeholder' => Yii::t('structure', 'Select a place ...'), 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'empAdd')->widget(Select2::className(), [
//        'initValueText' => $cityDesc, // set the initial display text
        'options' => ['placeholder' => 'Search for a city ...', 'multiple' => true],
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
    ]) ?>

    <?= $form->field($model, 'action')->textarea(['rows' => 6]) ?>

    <?php //$form->field($model, 'user_id')->textInput() ?>

    <?php //$form->field($model, 'template')->textInput() ?>

    <?php //$form->field($model, 'repeat')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('planning', 'Create') : Yii::t('planning', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
