<?php

use app\modules\structure\models\Position;
use himiklab\sortablegrid\SortableGridView;
use kartik\helpers\Html as HtmlKart;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\structure\models\search\PositionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('structure', 'Positions');
$this->params['breadcrumbs'][] = $this->title;
/*$script = <<<JS
$(document).on('sortableSuccess', function(){
    jQuery.pjax.reload({container:"#positions-grid"});
});
JS;
$this->registerJs($script);*/
?>
<div class="position-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= $this->render('_form', ['model' => $model]); ?>

    <?php Pjax::begin(['id' => 'positions-grid']) ?>
        <?= SortableGridView::widget([
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'columns' => [
//                ['class' => 'yii\grid\SerialColumn'],
                'position',
                [
                    'label' => Yii::t('structure', 'Head position'),
                    'format' => 'html',
                    'value' => function(Position $model){return ($model->chief)?HtmlKart::icon('ok'):HtmlKart::icon('remove');}
                ],
                [
                    'label' => Yii::t('structure', 'Municipal position'),
                    'format' => 'html',
                    'value' => function(Position $model){return ($model->municipal)?HtmlKart::icon('ok'):HtmlKart::icon('remove');}
                ],
//                'weight',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template'=>'{update} {delete}',
                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
