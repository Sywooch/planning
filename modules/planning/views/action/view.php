<?php

use kartik\helpers\Html as HtmlKart;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\planning\models\Action */

$this->title = $model->action;
$this->params['breadcrumbs'][] = ['label' => Yii::t('planning', 'Actions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="action-view">

    <h1>
        <?= Html::encode($this->title) ?>
        <?= Html::a(HtmlKart::icon('pencil'), ['update', 'id' => $model->id]) ?>
        <?= Html::a(HtmlKart::icon('trash'), ['delete', 'id' => $model->id], [
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])?>
    </h1>

    <p>
        <?= Html::tag('button', Yii::t('planning', 'Transfer action'), ['class' => 'btn btn-default', 'data-toggle' => 'modal', 'data-target' => '#transfer-modal']) ?>
    </p>

    <?php
    Modal::begin([
        'id' => 'transfer-modal',
        'header' => '<h3>'.Yii::t('planning', 'Transferring action').'</h3>',
    ]);
    ?>
        <div class="transfer-form">
            <?php $form = ActiveForm::begin([
                'action' => Url::toRoute(['/planning/action/transfer', 'id' => $model->id]),
                'method' => 'post'
            ]) ?>

            <?= $this->render('_dateFields', ['form' => $form, 'model' => $model]) ?>

            <?= $form->field($model, 'places')->widget(Select2::className(), [
                'data' => ArrayHelper::map(\app\modules\planning\models\Place::find()->all(), 'id', 'place'),
                'options' => ['multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>

            <div class="form-group">
                <label class="control-label" for="note"><?= Yii::t('planning', 'Note') ?></label>
                <?= Html::textarea('note','',['id' => 'note', 'class' => 'form-control', 'rows' => 3]) ?>
            </div>

            <div class="modal-footer">
                <?= Html::submitButton(Yii::t('planning', 'Transfer action'),['class' => 'btn btn-success']) ?>
                <?= Html::button(Yii::t('app', 'Cancel'),['class' => 'btn btn-danger', 'data-dismiss' => 'modal']) ?>
            </div>

            <?php ActiveForm::end() ?>
        </div>
    <?php Modal::end();?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'dateStart:datetime',
            'dateStop:datetime',
            [
                'label' => Yii::t('planning', 'Category'),
                'value' => ($model->isMonth())?$model->category->name:'',
                'visible' => $model->isMonth()
            ]
            ,
            [
                'label' => Yii::t('planning', 'Places'),
                'format' => 'html',
                'value' => implode(', ', array_map(function(\app\modules\planning\models\Place $place){
                    return Html::a($place->place, ['/planning/place/view', 'id' => $place->id]);
                },$model->places))
            ],
            [
                'label' => Yii::t('planning', 'Author'),
                'value' => $model->author->username,
            ],
            [
                'attribute' => 'repeat',
                'visible' => $model->template
            ],
        ],
    ]) ?>

    <?php if(!empty($model->transfers)): ?>
        <h3><?= Yii::t('planning', 'Action transfers') ?></h3>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => new \yii\data\ArrayDataProvider([
                'allModels' => $model->transfers
            ]),
            'columns' => [
                'number',
                'old_start:datetime',
                'old_stop:datetime',
                [
                    'label' => Yii::t('planning', 'Previous places'),
                    'format' => 'html',
                    'value' => function(\app\modules\planning\models\Transfer $el){return $el->preparePlacesLinks();}
                ],
                'note',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'buttons' => [
                        'delete' => function($url, \app\modules\planning\models\Transfer $model){
                            return Html::a(
                                HtmlKart::icon('trash'),
                                ['/planning/action/delete-transfer', 'id' => $model->action_id, 'number' => $model->number],
                                [
                                    'title' => Yii::t('app', 'Delete'),
                                ]
                            );
                        },
                    ],
                ],
            ],
            'layout' => "{items}",
        ]) ?>
    <?php endif; ?>

</div>
