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
        Yii::$app->urlManager->addRules([
            'staff-list' => 'structure/staff-list/index',
            '<controller:[a-z\-]+>s' => 'structure/<controller>/index',
            '<controller:[a-z\-]+>/<id:\d+>' => 'structure/<controller>/view',
            '<controller:[a-z\-]+>/create' => 'structure/<controller>/create',
            '<controller:[a-z\-]+>/<id:\d+>/edit' => 'structure/<controller>/update',
            '<controller:[a-z\-]+>/<id:\d+>/delete' => 'structure/<controller>/delete',
        ],false);
    }
}
