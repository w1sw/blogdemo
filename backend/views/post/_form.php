<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
/*
 * 数据库查询：
第一种方法：
$psObjs = \common\models\Poststatus::find()->all();
$allStatus = \yii\helpers\ArrayHelper::map($psObjs,'post_status_id','name');
第二种方法：
$psObjs = Yii::$app->db->createCommand('selelct post_status_id,name from PostStatus');
$allStatus = \yii\helpers\ArrayHelper::map($psObjs,'post_status_id','name');
第三种方法：
$allStatus = \common\models\Poststatus::find()->select(['name','post_status_id'])->from('PostStatus')->indexBy('post_status_id')->column();
第四种方法：
$allStatus = (new \yii\db\Query())->select(['name','post_status_id'])->from('PostStatus')->indexBy('post_status_id')->column();
*/


?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'post_status_id')->dropDownList((new \yii\db\Query())->select(['name','post_status_id'])->from('PostStatus')->indexBy('post_status_id')->column(),['prompt'=>'请选择状态']);?>


    <?= $form->field($model, 'author_id')->dropDownList((new \yii\db\Query())->select(['name','author_id'])->from('Adminuser')->indexBy('author_id')->column(),['prompt'=>'请选择作者']);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '发布' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
