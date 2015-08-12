<?php

use app\modules\structure\models\Experience;
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
    <?php $expArray = $dataProvider->getModels() ?>
    <h2><?= Yii::t('structure', 'Work experience').' - '.Experience::getExperienceLength($expArray) ?></h2>
    <h2><?= Yii::t('structure', 'Municipal experience').' - '.Experience::getMunicipalExp($expArray) ?></h2>
    <?php Experience::getMunicipalExp($dataProvider->getModels()) ?>
    <?php Pjax::begin(['id' => 'emp-works', 'timeout' => 10000, 'enablePushState'=>false]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'relDepartment.department',
                'relPosition.position',
                'start:date',
                [
                    'attribute' => 'stop',
                    'format' => 'raw',
                    'value' => function(Experience $data) {
                        return ($data->stop !== null)?Yii::$app->formatter->asDate($data->stop):Yii::t('structure', 'Until now');
                    }
                ],
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
            'layout' => "{items}"
        ]); ?>
    <?php Pjax::end(); ?>

    <?= $this->render('_addWorkForm', [
        'model' => $model,
    ]) ?>
</div>
