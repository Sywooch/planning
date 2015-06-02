<?php

namespace app\modules\structure\controllers;

use app\modules\structure\models\Phone;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PhoneController extends Controller{

    public function actionDelete() {
        /* @var Phone $phone */
        if(Yii::$app->request->isPost && Yii::$app->request->isAjax){
            $id = Yii::$app->request->post('id');
            if(($phone = Phone::findOne($id)) !== null){
                $phone->delete();
            }
        }
        else
            throw new NotFoundHttpException('Error!');
    }
} 