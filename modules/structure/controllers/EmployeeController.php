<?php

namespace app\modules\structure\controllers;

use app\modules\structure\models\Department;
use Yii;
use app\modules\structure\models\Employee;
use app\modules\structure\models\search\EmployeeSearch;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends Controller
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
     * Lists all Employee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Employee model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => Employee::find()->with(['position', 'department'],true, 'RIGHT JOIN')->where(['{{%employee}}.id'=>$id])->one(),
        ]);
    }

    /**
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Employee();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Employee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Employee model.
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
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionEmployeeList($q = null)
    {
        if(Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $out = ['results' => ['id' => '', 'text' => '']];
            if (!is_null($q)) {
                $query = (new Query())
                    ->select(['{{%employee}}.id', 'fio', 'position', 'department'])
                    ->from('{{%employee}}')
                    ->leftJoin('{{%experience}}', '{{%employee}}.id = {{%experience}}.employee_id')
                    ->leftJoin('{{%staff_list}}', '{{%experience}}.staff_unit_id = {{%staff_list}}.id')
                    ->leftJoin('{{%position}}', '{{%staff_list}}.position_id = {{%position}}.id')
                    ->leftJoin('{{%department}}', '{{%staff_list}}.department_id = {{%department}}.id')
                    ->where('{{%experience}}.stop IS NULL OR {{%experience}}.stop >= now()')
                    ->andWhere('fio LIKE "%'.$q.'%"');
                $command = $query->createCommand();
                $data = $command->queryAll();
                $data = ArrayHelper::map($data, 'id', function($el){
                    $el['full'] = $el['fio'].' - '.$el['position'].' '.Department::getDepartmentGenitive($el['department']);
                    return $el;
                });
                $out['results'] = array_values($data);
            }
            return $out;
        }
    }
}
