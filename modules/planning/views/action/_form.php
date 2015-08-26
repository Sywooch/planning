<?php

use app\modules\planning\models\Category;
use app\modules\planning\models\Option;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\modules\planning\models\Action */
/* @var $form yii\widgets\ActiveForm */
$url = \yii\helpers\Url::toRoute('/planning/flag/with-option');
$script = <<<JS
    $('input[name="Action[flags][]"]').change(function(){
    var opt = ($('#action-options').select2('val'));
        $.ajax({
            url: "{$url}",
            //type: 'post',
            dataType: "json",
            data:{id:$(this).val(), checked:$(this).prop("checked"), opt:(opt)?opt.join(','):opt},
            success: function(data){
                $('#action-options').select2('val', data);
            }
        });
    });
JS;
$this->registerJs($script);
?>

<div class="action-form">

    <?php $form = ActiveForm::begin(['fieldConfig' => ['errorOptions' => ['class'=>'help-block', 'encode' => false]]]); ?>

    <?= $this->render('_dateFields', ['form' => $form, 'model' => $model]) ?>

    <?php if($model->isMonth()): ?>
        <?= $form->field($model, 'category_id')
            ->dropDownList(
                ArrayHelper::map(Category::find()->asArray()->all(), 'id', 'name'),
                ['prompt' => Yii::t('planning', 'Select a category ...')]
            )
        ?>
    <?php endif; ?>

    <?= $form->field($model, 'flags')->checkboxList(
        ArrayHelper::map(\app\modules\planning\models\Flag::find()->asArray()->all(), 'id', 'name'),
        ['separator' => '<br/>']
    ) ?>

    <?= $form->field($model, 'places')->widget(Select2::className(), [
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

    <?= $form->field($model, 'options')->widget(Select2::className(), Option::configForSelect2()) ?>

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
