<?php

namespace app\modules\structure\controllers;

use app\modules\structure\models\Employee;
use Yii;
use app\modules\structure\models\Experience;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ExperienceController implements the CRUD actions for Experience model.
 */
class ExperienceController extends Controller
{
    public function behaviors()
    {
        return [
            /*'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],*/
        ];
    }

    /**
     * Lists all Experience models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Experience::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Experience model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Experience model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Experience();
        $model->load(Yii::$app->request->post());
        $model->staff_unit_id = $model->position;
        if ($model->save()) {
            $model = new Experience(['employee_id' => $model->employee_id]);
        }
        $dataProvider = new ActiveDataProvider(['query' => Employee::findOne(['id' => $model->employee_id])->getExtendedExperience()]);
        return $this->render('create', [
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Updates an existing Experience model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Url::previous('employee')); //['view', 'id' => $model->id]
        } else {
            Url::remember(Yii::$app->request->referrer, 'employee');
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Experience model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        if(Yii::$app->request->isAjax){
            $newModel = new Experience(['employee_id' => $model->employee_id]);
            $dataProvider = new ActiveDataProvider(['query' => Employee::findOne(['id' => $model->employee_id])->getExperience()]);


            return $this->render('create', [
                'model' => $newModel,
                'dataProvider' => $dataProvider
            ]);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Experience model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Experience the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Experience::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
