<?php

namespace app\modules\structure;

use yii\web\AssetBundle;

class EmployeeFormAsset extends AssetBundle {
    public $sourcePath = '@structure/assets';
    public $css = [
        'css/phone.css'
    ];
    public $js = [
        'js/addPhone.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
    ];
}