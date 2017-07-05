<?php

use yii\helpers\Html;
use common\models\Adminuser;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Adminuser */
$model = Adminuser::findOne($id);
$this->title = '权限设置 ：' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '管理员', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $id]];
$this->params['breadcrumbs'][] = '权限设置';
?>
<div class="adminuser-form">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="adminuser-privilege-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= Html::checkboxList('newPir',$AuthAssignmentsArray,$allPrivilegesArray);?>

        <div class="form-group">
            <?= Html::submitButton('修改', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
