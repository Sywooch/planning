<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\planning\models\Action */

$this->title = $model->action;
$this->params['breadcrumbs'][] = ['label' => Yii::t('planning', 'Actions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="action-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('planning', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('planning', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('planning', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'dateStart',
            'dateStop',
            [
                'label' => Yii::t('planning', 'Category'),
                'value' => $model->category->name,
                'visible' => $model->isMonth()
            ]
            ,
//            'action:ntext',
            [
                'label' => Yii::t('planning', 'Author'),
                'value' => $model->author->username,
            ],
//            'week_status',
//            'confirmed',
//            'created_at',
//            'updated_at',
//            'month_status',
//            'month',
//            'week',
            'template',
            'repeat',
        ],
    ]) ?>

</div>
