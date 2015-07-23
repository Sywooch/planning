<?php

use app\modules\planning\models\Flag;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \app\modules\planning\models\Flag */

$this->title = Yii::t('planning', 'Flags');
$this->params['breadcrumbs'][] = $this->title;
Icon::map($this, Icon::FA);
?>
<div class="flag-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['model' => $model]) ?>

    <?php Pjax::begin(['id' => 'flag-grid']) ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'name',
                'description',
                [
                    'attribute' => 'icon',
                    'format' => 'raw',
                    'value' => function(Flag $data){
                        return $data->getIcon();
                    }
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php Pjax::end() ?>

</div>
