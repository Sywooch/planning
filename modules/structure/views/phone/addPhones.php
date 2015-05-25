<?php
/* @var $this yii\web\View */
use app\modules\structure\EmployeeFormAsset;

EmployeeFormAsset::register($this);
?>
<div class="form-group field-add-phones">
    <?= $this->render('_phone', ['mask'=> '(999)999-99-99', 'type'=>'mobile']) ?>
    <?= $this->render('_phone', ['mask'=> '99-99-99', 'type'=>'work', 'icon'=>'earphone']) ?>
</div>
<div id="field-phones" class="form-group"></div>