<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \app\modules\planning\models\search\ActionSearch */

$this->title = Yii::t('planning', 'Actions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="action-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('planning', 'Create Action'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'dateStart',
            'dateStop',
            'category_id',
            'action:ntext',
            // 'user_id',
            // 'week_status',
            // 'confirmed',
            // 'created_at',
            // 'updated_at',
            // 'month_status',
            // 'month',
            // 'week',
            // 'template',
            // 'repeat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
