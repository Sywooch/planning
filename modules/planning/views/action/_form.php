<?php

use app\modules\planning\models\Category;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\modules\planning\models\Action */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="action-form">

    <?php $form = ActiveForm::begin(); ?>

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

    <?php if($model->isMonth()): ?>
        <?= $form->field($model, 'category_id')
            ->dropDownList(
                ArrayHelper::map(Category::find()->asArray()->all(), 'id', 'name'),
                ['prompt' => Yii::t('planning', 'Select a category ...')]
            )
        ?>
    <?php endif; ?>

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

    <?= $this->render('_empInput', ['form' => $form, 'model' => $model, 'attribute' => 'headEmployees'])  ?>
    <?= $this->render('_empInput', ['form' => $form, 'model' => $model, 'attribute' => 'responsibleEmployees'])  ?>
    <?= $this->render('_empInput', ['form' => $form, 'model' => $model, 'attribute' => 'invitedEmployees'])  ?>

    <?= $form->field($model, 'action')->textarea(['rows' => 6]) ?>

    <?php $model->user_id = Yii::$app->user->id ?>
    <?=  $form->field($model, 'user_id')
            ->dropDownList(ArrayHelper::map(\app\models\User::find()->asArray()->all(), 'id', 'username'))
    ?>

    <?php //$form->field($model, 'template')->textInput() ?>

    <?php //$form->field($model, 'repeat')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('planning', 'Create') : Yii::t('planning', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
