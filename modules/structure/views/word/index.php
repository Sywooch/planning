<?php

use app\modules\structure\models\Word;
use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('structure', 'Words');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('
    $("#initialize-dictionaries").click(function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr("href"),
            type: "post",
            success: function($data){
                $("#initialize-result").html($data);
            }
        });
    });
');

?>
<div class="word-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('structure', 'Create word'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(
            Yii::t('structure', 'Update dictionaries'),
            ['initialize-dictionaries'],
            ['id' => 'initialize-dictionaries','class' => 'btn btn-info']
        ) ?>
        <span id="initialize-result"></span>
    </p>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->word), ['view', 'id' => $model->word]).' - '.
                Html::encode(Word::getTypes()[$model->type]);
        },
    ]) ?>

</div>
