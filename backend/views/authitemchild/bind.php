<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AuthItemChild */

$this->title = '绑定角色权限关系';
$this->params['breadcrumbs'][] = ['label' => '角色与权限关系表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-child-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>
        <?php if($model->isNewRecord){$model->parent=$parent;}?>
        <?= $form->field($model,'parent')->radioList($allRoleArray)?>

        <div class="form-group">
            <?= Html::submitButton('确定', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>



    <br>



    <?php $form = ActiveForm::begin(['action'=>['authitemchild/starbind','parent'=>$parent],'method'=>'post']); ?>

    <?= Html::checkboxList('newPir',$AuthItemArray,$allPrivilegesArray);?>   <!--第一个是name属性，第二个是已选，第三个是所有值-->

    <div class="form-group">
        <?= Html::submitButton('确定', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
