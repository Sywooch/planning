<?php

use kartik\helpers\Html as HtmlKart;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\structure\models\Department */
/* @var $employees array */

$this->title = $model->department;
//$model->getEmployees()->all();
$this->params['breadcrumbs'][] = ['label' => Yii::t('structure', 'Departments'), 'url' => ['index']];
if($model->parent !== null)
    $this->params['breadcrumbs'][] = ['label' => Html::encode($model->parent), 'url' => ['view', 'id' => $model->parent->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="department-view">

    <h1>
        <?= Html::encode($this->title) ?>
        <?php if (Yii::$app->user->can('Department Manage')): ?>
            <?= Html::a(HtmlKart::icon('pencil'), ['update', 'id' => $model->id]) //['class' => 'btn btn-primary'] ?>
            <?= Html::a(HtmlKart::icon('trash'), ['delete', 'id' => $model->id], [
                'data' => [
                    'confirm' => Yii::t('structure', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ])?>
        <?php endif; ?>
    </h1>

    <?php if(!array_key_exists(null, $employees)): ?>
        <h3><?= Yii::t('structure', 'List of employees') ?></h3>
        <ol>
            <?php foreach($employees as $key => $employee): ?>
                <li><?= Html::a(Html::encode($employee['fio']), ['employee/view', 'id' => $key]).' - '.$employee['position'] ?></li>
            <?php endforeach; ?>
        </ol>
    <?php endif; ?>

    <?php if(!empty($model->child)): ?>
        <h3><?= Yii::t('structure', 'Departments') ?></h3>
        <ol>
            <?php foreach($model->child as $key => $dep):?>
                <li>
                    <?= Html::a(Html::encode($dep->department), ['view', 'id' => $dep->id]) ?>
                    <?= Yii::t('structure', 'There {n, plural, =0{are no employees} =1{is one employee} other{are # employees}}', ['n' => count($dep->experience)]) ?>
                </li>
            <?php endforeach; ?>
        </ol>
    <?php endif; ?>
</div>
