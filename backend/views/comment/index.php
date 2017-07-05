<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \common\models\Comment;
use \common\models\Commentstatus;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评论管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'comment_id',
            [
                'attribute'=>'comment_id',
                'contentOptions'=>['width'=>'50px'],
            ],
            [
                'attribute'=>'content',
                'value'=>'begining'
            ],
//            'userid',
            [
                'attribute'=>'user.username',
                'label'=>'用户',
                'value'=>'user.username'
            ],
            [
                'attribute'=>'comment_status_id',
                'value'=>'commentStatus.name',
                'filter'=>Commentstatus::find()->select(['name','comment_status_id'])->indexBy('comment_status_id')->column(),
                'contentOptions'=>function ($model){   //用匿名函数来返回值，以便于应对不同情况下的需求
                    return ($model->comment_status_id==1)?['class'=>'bg-danger']:[];
                }
            ],
//            'create_time:datetime',
            [
                'attribute'=>'create_time',
                'format'=>['date','php:m-d H:i'],
            ],
            // 'email:email',
            // 'url:url',
            // 'post_id',
            [
                'attribute'=>'post.title',
                'label'=>'评论文章',
                'value'=>'post.title',
            ],
            [   //动作列
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view}{update}{delete}{approve}',
                'buttons'=>
                    [
                        'approve'=>function($url,$model,$key){
                            $options=
                                [
                                    'title'=>Yii::t('yii','审核'),
                                    'aria-label'=>Yii::t('yii','审核'),
                                    'data-confirm'=>Yii::t('yii','你确定通过这条记录吗？'),
                                    'data-method'=>'post',
                                    'data-pjax'=>'0',
                                ];
                            return Html::a('<sapn class="glyphicon glyphicon-check"></sapn>',$url,$options);
                        },
                    ],
            ],
        ],
    ]); ?>

</div>
