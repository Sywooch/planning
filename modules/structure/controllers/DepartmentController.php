<?php

namespace app\modules\structure\controllers;

use Yii;
use app\modules\structure\models\Department;
use app\modules\structure\models\search\DepartmentSearch;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DepartmentController implements the CRUD actions for Department model.
 */
class DepartmentController extends Controller
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
     * Lists all Department models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DepartmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Department model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        //@todo ѕриудалении employee_id остаетс€ только одна запись, оп€ть вернутьс€ к AR добавив к селекту employee_id
        $employees = (new Query())
            ->select(['employee_id', 'fio', 'position'])
            ->from('{{%department}}')
            ->leftJoin('{{%staff_list}}', '{{%department}}.id = {{%staff_list}}.department_id')
            ->leftJoin('{{%experience}}', '{{%staff_list}}.id = {{%experience}}.staff_unit_id')
            ->leftJoin('{{%position}}', '{{%staff_list}}.position_id = {{%position}}.id')
            ->leftJoin('{{%employee}}', '{{%experience}}.employee_id = {{%employee}}.id')
            ->where(['{{%department}}.id' => $id])
            ->andWhere('{{%experience}}.stop IS NULL OR {{%experience}}.stop >= now()')
            ->indexBy('employee_id')
            ->all();
        return $this->render('view', [
            'model' => Department::find()->with(['parent','child'])->where(['{{%department}}.id' => $id])->one(),
            'employees' => $employees
        ]);
    }

    /**
     * Creates a new Department model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Department();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Department model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Department model.
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
     * Finds the Department model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Department the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Department::find()->with('parent', 'child')->where(['id'=>$id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
