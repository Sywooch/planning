<?php

namespace app\modules\structure;

use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\structure\controllers';

    public function init()
    {
        parent::init();

        if (!isset(Yii::$app->i18n->translations['structure'])) {
            Yii::$app->i18n->translations['structure'] = [
              'class' => 'yii\i18n\PhpMessageSource',
              'sourceLanguage' => 'en',
              'basePath' => '@structure/messages'
            ];
        }
    }
}
