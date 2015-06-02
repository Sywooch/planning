<?php
/**
 * @var $this yii\web\View
 * @var $phone app\modules\structure\models\Phone
 * @var $type string
 */
if(isset($phone)){
    $type = $phone->type;
}
use app\modules\structure\models\Phone;
use yii\helpers\Url;
use yii\widgets\MaskedInput;

?>
<div class="input-group">
    <span class="input-group-addon">
        <i class="<?= Phone::getIcon($type) ?>"></i>
    </span>
    <?= MaskedInput::widget([
    'name'=>'template',
    'mask'=>Phone::getMask($type),
    'value' => (isset($phone))?$phone->phone:'',
    'options'=>[
        'class'=>'form-control',
        'disabled'=>(isset($phone))?true:false,
    ],
    ]) ?>
    <span class="input-group-btn">
        <button <?=(isset($phone)?'data-id='.$phone->id.' data-url='.Url::to(['/structure/phone/delete']):'')?> type="button" class="btn btn-danger delete-phone">
            <i class="glyphicon glyphicon-remove"></i>
        </button>
    </span>
</div>