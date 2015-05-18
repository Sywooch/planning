<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\planning\models\Category */

$this->title = Yii::t('planning', 'Create Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('planning', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
