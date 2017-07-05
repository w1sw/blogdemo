<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->post_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->post_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'post_id',
            'title',
            'content:ntext',
            'tags:ntext',
//            'post_status_id',
            ['attribute'=>'post_status_id','value'=>$model->postStatus->name,],
//            'update_time:datetime',
//            'create_time:datetime',
            ['attribute'=>'update_time','value'=>date('Y-m-d H:i:s',$model->update_time)],
            ['attribute'=>'create_time','value'=>date('Y-m-d H:i:s',$model->create_time)],
            ['attribute'=>'author_id','value'=>$model->author->name]
        ],
    ]) ?>

</div>
