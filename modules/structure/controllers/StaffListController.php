<?php

namespace app\modules\structure\controllers;

use Yii;
use app\modules\structure\models\StaffList;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StaffListController implements the CRUD actions for StaffList model.
 */
class StaffListController extends Controller
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
     * Lists all StaffList models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new StaffList();

        if($model->load(Yii::$app->request->post()) && $model->save()) {
            $model = new StaffList();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => StaffList::find()->joinWith(['department', 'position']),
            'sort' => [
                'attributes' => [
                    'department.department' => [
                        'asc' => ['{{%department}}.department' => SORT_ASC],
                        'desc' => ['{{%department}}.department' => SORT_DESC],
                    ],
                    'position.position' => [
                        'asc' => ['{{%position}}.position' => SORT_ASC],
                        'desc' => ['{{%position}}.position' => SORT_DESC],
                    ],
                    'count'
                ]
            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    /**
     * Displays a single StaffList model.
     * @param integer $department_id
     * @param integer $position_id
     * @return mixed
     */
    /*public function actionView($department_id, $position_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($department_id, $position_id),
        ]);
    }*/

    /**
     * Creates a new StaffList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StaffList();
        $model->loadDefaultValues();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'department_id' => $model->department_id, 'position_id' => $model->position_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing StaffList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'department_id' => $model->department_id, 'position_id' => $model->position_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing StaffList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDepPos() {
        if(isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $dep_id = $parents[0];
                $out = (new Query())
                    ->select(['staff.id AS id', 'pos.position AS name'])
                    ->from('{{%staff_list}} staff')
                    ->where(['department_id'=>$dep_id])
                    ->andWhere('staff.count > 0')
                    ->innerJoin('{{%position}} pos', 'staff.position_id = pos.id')
                    ->all();
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    /**
     * Finds the StaffList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StaffList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StaffList::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
