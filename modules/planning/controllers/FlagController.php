<?php

namespace app\modules\planning\controllers;

use Yii;
use app\modules\planning\models\Flag;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * FlagController implements the CRUD actions for Flag model.
 */
class FlagController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Flag models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Flag();

        $dataProvider = new ActiveDataProvider([
            'query' => Flag::find(),
        ]);
        if($model->load(Yii::$app->request->post()) && $model->save()){
            $model = new Flag();
        }
        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Flag model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Flag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Flag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Flag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Flag::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionWithOption($id, $checked, $opt)
    {
        /* @var Flag $model */
        $checked = ($checked === 'true');
        $opt = explode(',', $opt);
        if(Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = Flag::find()->joinWith('options')->where(['{{%flag}}.id' => $id])->one();
            foreach($model->options as $option){
                if($checked)
                    array_push($opt, $option->id);
                else
                    unset($opt[array_search($option->id, $opt)]);
            }
            return array_unique($opt);
        }
    }
}
