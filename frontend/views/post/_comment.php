<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php foreach ($comments as $comment):?>

<div class="comment">
    <div class="row">
        <div class="col-md-12">
            <div class="comment_detail">
                <p class="bg-info">
                    <span class="glyphicon glyphicon-user" aria-hidden="true"><?=Html::encode($comment->user->username);?></span>
                    <br>
                    <?= nl2br($comment->content);?>
                    <br>
                    <span class="glyphicon glyphicon-time" aria-hidden="true"><?=date('Y-m-d H:i:s',$comment->create_time)?></span>
                </p>
            </div>
        </div>
    </div>
</div>

<?php endforeach;?>