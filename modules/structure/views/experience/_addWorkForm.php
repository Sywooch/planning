<?php

use app\modules\structure\models\Department;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\structure\models\Experience */
/* @var $form yii\widgets\ActiveForm */
?>
<?php

$this->registerJs(
    '$("document").ready(function(){
        $("#exp").on("pjax:end", function() {
            $.pjax.reload({container:"#emp-works"});  //Reload GridView
        });
    });'
);
?>
<div class="experience-form">
    <?php Pjax::begin(['id' => 'exp', 'enablePushState'=>false]); ?>
        <?php $form = ActiveForm::begin([
            'id'=>'exp-form',
            'action' => Url::toRoute('experience/create'),
            'options' => ['data-pjax' => true ]
        ]); ?>
        <?= $form->field($model, 'employee_id')->hiddenInput()->label(false); ?>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?= $form->field($model, 'start')->widget(DatePicker::className()) ?>
            </div>
            <div class="col-sm-12 col-md-6">
                <?= $form->field($model, 'stop')->widget(DatePicker::className()) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?= $form->field($model, 'department')->label(Yii::t('structure', 'Department'))->widget(Select2::className() ,[
                    'data'=> ArrayHelper::map(Department::find()->asArray()->all(), 'id', 'department'),
                    'options' => ['id' => 'department-id', 'placeholder' => Yii::t('structure', 'Select a department ...')],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
            <div class="col-sm-12 col-md-6">
                <?= $form->field($model, 'position')->label(Yii::t('structure', 'Position'))->widget(\kartik\widgets\DepDrop::className(), [
                    'options'=>['id'=>'position-id'],
                    'pluginOptions'=>[
                        'depends'=>['department-id'],
                        'placeholder'=>Yii::t('structure', 'Select a position ...'),
                        'url'=>Url::to(['staff-list/dep-pos'])
                    ]
                ]) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('structure', 'Add place of work'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>

</div>
