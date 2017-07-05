<?php
/**
 * Created by PhpStorm.
 * User: Dengchengfu
 * Date: 17/3/14
 * Time: 上午11:56
 */
namespace frontend\components;

use yii\Base\Widget;
use yii\helpers\Html;

class TagsCloudWidget extends Widget{

    public $tags;   //准备的数据

    public function init(){
        parent::init();
    }

    public function run(){      //在run方法中渲染数据
        $tag_string = '';       //标签云的html代码
        $fontStyle=array(       //标签云的各种样式
            '6'=>'danger',
            '5'=>'info',
            '4'=>'warning',
            '3'=>'primary',
            '2'=>'success',
        );
        foreach ($this->tags as $tag=>$weight){
            $tag_string .='<a href="'.\Yii::$app->homeUrl.'?=post/index&PostSearch[tags]='
                .$tag.'">'
                .' <h'.$weight.' style="display:inline-block;"><span class="label label-'
                .$fontStyle[$weight].'">'.$tag.'</span></h'.$weight.'></a>';
        }
        return $tag_string;
    }
}