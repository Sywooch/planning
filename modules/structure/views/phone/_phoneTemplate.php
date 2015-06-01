<?php
/* @var $this yii\web\View */
/* @var $type string */
/* @var $model string */

use app\modules\structure\models\Phone;
use yii\helpers\Html;

$typeName = Phone::getType($type);
?>
<?= Html::button(
    Yii::t('structure', Yii::t('structure', 'Add {type} phone', ['type'=>Yii::t('structure', $typeName)])),
    ['id' => $typeName .'-phone','class' => 'btn btn-default add-phone']
) ?>
<div data-model="<?= $model ?>" class="<?= $typeName ?>-phone phone template" style="display: none">
    <?= $this->render('_phone', ['type'=>$type]) ?>
    <?= Html::hiddenInput('template', $type) ?>
</div>