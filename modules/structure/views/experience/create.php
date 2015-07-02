<?php

use kartik\helpers\Html as HtmlKart;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model app\modules\structure\models\Experience */
/* @var $dataProvider \yii\data\ActiveDataProvider */

//$this->title = Yii::t('structure', 'Create Experience');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('structure', 'Experiences'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;

?>
<div class="experience-create">

    <h2><?= Yii::t('structure', 'Places of work') ?></h2>
    <?= $this->render('_addWorkForm', [
        'model' => $model,
    ]) ?>

    <?php
        Pjax::begin(['id' => 'edit-form']);
        Pjax::end();
    ?>

    <?php Pjax::begin(['id' => 'emp-works', 'timeout' => 10000, 'enablePushState'=>false]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            'start:date',
            'stop:date',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function($url, $model) {
                        return Html::a(
                            HtmlKart::icon('pencil'),
                            ['experience/update', 'id' => $model->id],
                            [
                                'title' => Yii::t('app', 'Edit'),
                                'data-pjax' => '0'
                            ]
                        );
                    },
                    'delete' => function($url, $model){
                        return Html::a(
                            HtmlKart::icon('trash'),
                            ['experience/delete', 'id' => $model->id],
                            [
                                'title' => Yii::t('app', 'Delete'),
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
