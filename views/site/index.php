<?php
/* @var $this yii\web\View */
$this->title = 'Портал Администрации города Волгодонска';
?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Система планирования</h2>

                <p><a class="btn btn-success btn-block" href="<?= \Yii::$app->urlManager->createUrl('planning') ?>">Перейти &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Система подачи заявок</h2>

                <p><a class="btn btn-success btn-block" href="#">Перейти &raquo;</a></p>
            </div>
        </div>
    </div>
</div>
