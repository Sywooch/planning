<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('structure', 'Staff list');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-list-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['model' => $model]) ?>

    <?php Pjax::begin(['id' => 'staff-list-grid']) ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'department.department',
                'position.position',
                'count',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template'=>'{update} {delete}',
                ],
            ],
            'layout' => "{items}\n{pager}",
        ]); ?>
    <?php Pjax::end() ?>


</div>
