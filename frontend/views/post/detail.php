<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\grid\GridView;
use yii\widgets\ListView;
use \frontend\components\TagsCloudWidget;
use \frontend\components\RctReplyWidget;
use \common\models\Comment;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <ol class="breadcrumb">
                <li><a href="<?= Yii::$app->homeUrl;?>">首页</a></li>
                <li><a href="<?= Yii::$app->homeUrl;?>?r=post/index">文章列表</a></li>
                <li class="active"><?=$model->title;?></li>
            </ol>

            <div class="post">
                <div class="title">
                    <h2><a href="<?=$model->url?>"><?=$model->title;?></a></h2>
                    <div class="author">
                        <span class="glyphicon glyphicon-time" aria-hidden="true"></span><em><?=date('Y-m-d H:i:s',$model->create_time); ?>&nbsp;&nbsp;&nbsp;&nbsp;</em>
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span><em><?=Html::encode($model->author->name);?></em>
                    </div>
                </div>
            </div>
            <div class="content">
                <?= HTMLPurifier::process($model->content)?>
            </div>
            <br>
            <div class="nav">
                <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
                <?=implode(',',$model->tagLinks);?>
                <br>
                <?=Html::a('评论('.$model->commentCount.')',$model->url.'#comment')?>&nbsp;&nbsp;&nbsp;|
                最后修改于<?= date('Y-m-d H:i:s',$model->create_time);?>
            </div>

            <!--评论区-->
            <div id="comments">
                <?php if ($added)    {?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4>谢谢您的回复，我们会尽快审核后发布出来！</h4>
                    <p><?=nl2br($commentModel->content)?></p>
                    <span class="glyphicon glyphicon-time" aria-hidden="true"><?=date('Y-m-d H:i:s',$commentModel->create_time)?></span><!--这里为什么是model-->
                    <span class="glyphicon glyphicon-time" aria-hidden="true"><?=$model->author->name?></span>
                </div>
                <?php }?>

                <?php if($model->commentCount>=1):?>
                    <?=$this->render('_comment',array(
                        'post'=>$model,
                        'comments'=>$model->activeComments,
                    ));?>
                <?php endif?>

                <h5>发表评论</h5>
                <?php
                $postComment = new Comment();
                echo $this->render('_guestform',array(
                    'id'=>$model->post_id,
                    'commentModel'=>$commentModel,
                    'recentComment'=>$recentComment
                ));
                ?>
            </div>

        </div>
        <div class="col-md-3">
            <div class="searchhbox">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="glyphicon glyphicon-search" aria-hidden="true">查看文章</span>
                    </li>
                    <li class="list-group-item">
                        <form class="form-inline" action="index.php?r=post/index" id="w0" method="get">
                            <div class="form-group">
                                <input type="text" class="form-control" name="PostSearch[title]" id="w0input" placeholder="按标题">
                            </div>
                            <button type="submit" class="btn btn-default">搜索</button>
                        </form>
                    </li>
                </ul>
            </div>

            <div class="tagcloudbox">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="glyphicon glyphicon-tags" aria-hidden="true">标签云</span>
                    </li>
                    <li class="list-group-item">
                        <?= TagsCloudWidget::widget(['tags'=>$tags])?>
                    </li>
                </ul>
            </div>

            <div class="commentbox">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="glyphicon glyphicon-comment" aria-hidden="true">最新回复</span>
                    </li>
                    <li class="list-group-item">
                        <?= RctReplyWidget::widget(['recentComment'=>$recentComment])?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
