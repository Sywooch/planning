<?php

use app\modules\structure\models\Department;
use app\modules\structure\models\Position;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\structure\models\StaffList */
/* @var $form yii\widgets\ActiveForm */
?>

<?php

$this->registerJs(
    '$("document").ready(function(){
        $("#new-staff-unit").on("pjax:end", function() {
            $.pjax.reload({container:"#staff-list-grid"});  //Reload GridView
        });
    });'
);
?>

<div class="staff-list-form">
    <?php Pjax::begin(['id' => 'new-staff-unit', 'enablePushState'=>false]) ?>
        <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>

        <?= $form->field($model, 'department_id')->widget(Select2::className() ,[
            'data'=> ArrayHelper::map(Department::find()->asArray()->all(), 'id', 'department'),
            'options' => ['placeholder' => Yii::t('structure', 'Select a department ...')],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>

        <?= $form->field($model, 'position_id')->widget(Select2::className() ,[
            'data'=> ArrayHelper::map(Position::find()->asArray()->all(), 'id', 'position'),
            'options' => ['placeholder' => Yii::t('structure', 'Select a position ...')],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>

        <?= $form->field($model, 'count')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    <?php Pjax::end() ?>

</div>
