<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AuthItem */

$this->title = '添加角色';
$this->params['breadcrumbs'][] = ['label' => '角色列表', 'url' => ['index-role']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_role', [
        'model' => $model,
    ]) ?>

</div>
