<?php

use app\modules\planning\models\Action;
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
        <?= Html::a(Yii::t('planning', 'Create week action'),['/planning/action/create', 'type' => Action::WEEK], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('planning', 'Create month action'),['/planning/action/create', 'type' => Action::MONTH], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'dateStart',
            'dateStop',
            [
                'attribute' => 'category',
                'value' => 'category.name'
            ],
            'action',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
