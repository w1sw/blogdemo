<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \common\models\Poststatus;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,        //指定提供数据的数据提供者
        'filterModel' => $searchModel,          //指定一个能够提供搜索过滤功能的搜索模型类
        'columns' => [                          //指定需要展示的列及其格式
//            ['class' => 'yii\grid\SerialColumn'],     //序号
            ['attribute'=>'post_id','contentOptions'=>['width'=>'30px']],
            'title',
            'tags:ntext',
            [
                'attribute'=>'post_status_id',
                'value'=>'postStatus.name',
                'filter'=>Poststatus::find()->select(['name','post_status_id'])->orderBy('post_status_id')->indexBy('post_status_id')->column(),
            ],
             'update_time:datetime',
             'create_time:datetime',
            ['attribute'=>'authorName','label'=>'作者','value'=>'author.name'],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
