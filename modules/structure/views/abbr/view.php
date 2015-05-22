<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\structure\models\Abbr */

$this->title = $model->abbr;
$this->params['breadcrumbs'][] = ['label' => Yii::t('structure', 'Abbrs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="abbr-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('structure', 'Update'), ['update', 'id' => $model->abbr], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('structure', 'Delete'), ['delete', 'id' => $model->abbr], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('structure', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'abbr',
        ],
    ]) ?>

</div>
