<?php
/* @var $this yii\web\View */
/* @var $mask string */
/* @var $type string */
/* @var $icon string */
use app\modules\structure\models\Phone;
use yii\helpers\Html;
use yii\widgets\MaskedInput;
?>
<?= Html::button(
    Yii::t('structure', Yii::t('structure', 'Add {type} phone', ['type'=>Yii::t('structure', $type)])),
    ['id' => $type.'-phone','class' => 'btn btn-default add-phone']
) ?>
<div class="<?= $type ?>-phone template" style="display: none">
    <div class="input-group">
        <span class="input-group-addon">
            <i class="glyphicon glyphicon-<?= (isset($icon))?$icon:'phone' ?>"></i>
        </span>
        <?=
        MaskedInput::widget([
            'name'=>'template',
            'mask'=>$mask,
            'options'=>[
                'class'=>'form-control',
            ],
        ]) ?>
        <span class="input-group-btn">
            <button type="button" class="btn btn-danger delete-phone">
                <i class="glyphicon glyphicon-remove"></i>
            </button>
        </span>
    </div>
    <?= Html::hiddenInput('template', constant(Phone::className().'::'.strtoupper($type))) ?>
</div>