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
            $this->id.'/staff-list' => 'structure/staff-list/index',
            $this->id.'/<controller:[a-z\-]+>s' => $this->id.'/<controller>/index',
            $this->id.'/<controller:[a-z\-]+>/<id:\d+>' => $this->id.'/<controller>/view',
            $this->id.'/<controller:[a-z\-]+>/create' => $this->id.'/<controller>/create',
            $this->id.'/<controller:[a-z\-]+>/<id:\d+>/edit' => $this->id.'/<controller>/update',
            $this->id.'/<controller:[a-z\-]+>/<id:\d+>/delete' => $this->id.'/<controller>/delete',
            $this->id.'/<controller:[a-z\-]+>/<action:\w+>' => $this->id.'/<controller>/<action>'
        ],false);
    }
}
