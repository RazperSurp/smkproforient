<?php

/** @var yii\web\View $this */

$this->title = $title;

$this->registerJsFile('web\js\site\index.mjs', ['type' => 'module']);
?>
<div class="site-index">
    <section class="user-border default-border d-flex justify-content-between profile-data" style="height: 100px">
        <div class="profile-data__user-name">
            <h2> <?= Yii::$app->user->identity->name ?> </h2>
            <small> <?= Yii::$app->user->identity->employeePosts->name ?> </small>
        </div>
        <div class="align-content-center profile-data__settings">
            <button class="h-75" cc-svg="settings"> </button>
        </div>
    </section>
</div>
