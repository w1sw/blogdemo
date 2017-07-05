<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use \yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel common\models\AuthItemChildSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$cssString = ".searchhbox{line-height: 34px;}";
$this->registerCss($cssString);

$this->title = '角色与权限关系表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-child-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="col-md-8">
        <p>
            <?= Html::a('绑定关系', ['bind'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('添加权限', ['authitem/create'], ['class' => 'btn btn-default']) ?>
            <?= Html::a('添加角色', ['authitem/create-role'], ['class' => 'btn btn-default']) ?>
        </p>
    </div>
    <div class="col-md-4">
<!--        <div class="searchhbox">-->
<!--            <form class="form-inline" action="--><?//= Url::to(['authitemchild/index'])?><!--" id="w1" method="get">-->
<!--                <div class="form-group">-->
<!--                    <input type="text" class="form-control" name="AuthItemChildSearch[allow]" id="w1input" placeholder="">-->
<!--                </div>-->
<!--                <button type="submit" class="btn btn-default">搜索</button>-->
<!--            </form>-->
<!--        </div>-->
        <div class="searchhbox">
            <?php
            $form = ActiveForm::begin([
                'id' => 'w1',
                'method'=>'get',
                'action' => ['authitemchild/index'],
                'options' => ['class' => 'form-inline'],
            ]) ?>
            <div class="form-group">

                <?= $form->field($searchModel, 'allow')->textInput()->label('权限搜索') ?>
                <?= Html::submitButton('搜索', ['class' => 'btn btn-default','style'=>'margin-top:-10px;']) ?>

            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>

    <div class="col-md-12">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'parent',
//            'child',
                ['attribute'=>'parent','label'=>'角色','value'=>'parent0.description'],
                [
                    'attribute'=>'allow',
                    'label'=>'权限',
                    'value'=>function($model){  //model是当前行的对象
                        return $model->getJurisdiction();
                    }
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>


</div>
