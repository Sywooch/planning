<?php
/* @var $this yii\web\View */
/* @var $model yii\db\ActiveRecord*/
use app\modules\structure\models\Phone;
use yii\helpers\StringHelper;

$modelStr = (isset($model)) ? StringHelper::basename($model::className()) : 'Template';
?>
<div class="form-group field-add-phones">
    <?= $this->render('_phoneTemplate', ['type'=>Phone::MOBILE, 'model'=> $modelStr]) ?>
    <?= $this->render('_phoneTemplate', ['type'=>Phone::WORK, 'model'=>$modelStr]) ?>
</div>
<div id="field-phones" class="form-group"></div>