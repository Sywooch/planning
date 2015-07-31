<?php
namespace app\modules\planning;

use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\planning\controllers';

    public function init()
    {
        parent::init();

        if (!isset(Yii::$app->i18n->translations['planning'])) {
            Yii::$app->i18n->translations['planning'] = [
              'class' => 'yii\i18n\PhpMessageSource',
              'sourceLanguage' => 'en',
              'basePath' => '@planning/messages'
            ];
        }
        Yii::$app->urlManager->addRules([
            $this->id.'/<controller:[a-z\-]+>/<type:(week|month)>/create' => $this->id.'/<controller>/create',
            $this->id.'/<controller:[a-z\-]+>/<id:\d+>/update' => $this->id.'/<controller>/update',
            $this->id.'/<controller:[a-z\-]+>/<id:\d+>' => $this->id.'/<controller>/view',
            $this->id.'/<controller:[a-z\-]+>/<id:\d+>/delete' => $this->id.'/<controller>/delete',
        ],true);
    }
}
