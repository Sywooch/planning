<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model \app\modules\planning\models\Option */
/* @var $searchModel app\modules\planning\models\search\OptionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('planning', 'Options');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="option-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= $this->render('_form', ['model' => $model]); ?>

    <?php Pjax::begin(['id' => 'option-grid']) ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'option',
                'duration',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php Pjax::end(); ?>

</div>
