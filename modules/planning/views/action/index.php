<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('planning', 'Actions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="action-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('planning', 'Create action'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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
