<?php

/** @var yii\web\View $this */

$this->title = $title;

$this->registerJsFile('web\js\site\index.mjs', ['type' => 'module']);
?>
<div class="site-index d-flex flex-direction-row justify-content-between gap-4">
    <div class="left-block w-100">
        <h2> Личная информация </h2>
        <section class="user-border default-border d-flex justify-content-between profile-data" style="margin-bottom: 20px">
            <div class="profile-data__user-name">
                <h4> <?= Yii::$app->user->identity->name ?> </h4>
                <small> <?= Yii::$app->user->identity->employeePosts->name ?> </small>
            </div>
            <div class="align-content-center profile-data__settings">
                <button class="h-75" cc-svg="settings"> </button>
            </div>
        </section>
        <h2> События </h2>
        <div class="user-events--wrapper">
            <div class="d-flex gap-4 user-events" id="user-events">
                <div cc-events> </div>
                <div cc-events> </div>
                <div cc-events> </div>
                <div cc-events> </div>
            </div> 
        </div> 
    </div>
    <div class="user-tasks--wrapper right-block">
        <h2> Задачи </h2>
        <div class="d-flex justify-content-between flex-column gap-4 user-tasks" id="user-tasks">
                <div cc-tasks> </div>
                <div cc-tasks> </div>
                <div cc-tasks> </div>
                <div cc-tasks> </div>
                <div cc-tasks> </div>
        </div>
    </div>
</div>
