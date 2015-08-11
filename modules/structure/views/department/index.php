<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\structure\models\search\DepartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model app\modules\structure\models\Department */

$this->title = Yii::t('structure', 'Departments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', ['model' => $model]); ?>

    <?php Pjax::begin(['id' => 'department-grid']) ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'department:ntext',
                [
                    'label' => Yii::t('structure', 'Head department'),
                    'value' => function(\app\modules\structure\models\Department $dep){
                        return ($dep->parent !== null)?$dep->parent->department:null;
                    }
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php Pjax::end() ?>

</div>
