<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

?>

<div class="comment-form">

    <?php $form = ActiveForm::begin([
        'action'=>['post/detail','id'=>$id,'#'=>'comments'],
        'method'=>'post',
    ]); ?>

    <div class="row">
<!--        $recentComment可能为空-->
        <div class="col-md-12"><?= $form->field($commentModel,'content')->textarea(['row'=>6])?></div>
    </div>



<div class="form-group">
    <?= Html::submitButton('发表评论', ['class' =>'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
