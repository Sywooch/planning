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
        ],true);
    }
}
