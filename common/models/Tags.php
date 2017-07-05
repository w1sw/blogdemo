<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property integer $tag_id
 * @property string $name
 * @property integer $frequency
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tag_id' => 'Tag ID',
            'name' => 'Name',
            'frequency' => 'Frequency',
        ];
    }
    //字符串转成数组
    public static function string2array($tags){
        return preg_split('/\s*,\s*/',trim($tags),-1,PREG_SPLIT_NO_EMPTY);
    }
    //数组转成字符串
    public static function array2string($tags){
        return implode(',',$tags);
    }
    //添加标签
    public static function addTags($tags){
        if(empty($tags))return ;
        foreach ($tags as $name){
            $aTag = Tags::find()->where(['name'=>$name])->one();
            $aTagCount = Tags::find()->where(['name'=>$name])->count();

            if(!$aTagCount){
                $tag = new Tags();
                $tag->name=$name;
                $tag->frequency = 1;
                $tag->save();
            }else{
                $aTag->frequency+=1;
                $aTag->save();
            }
        }
    }
    //删除标签
    public static function removeTags($tags){
        if(empty($tags))return ;
        foreach ($tags as $name){
            $aTag = Tags::find()->where(['name'=>$name])->one();
            $aTagCount = Tags::find()->where(['name'=>$name])->count();

            if($aTagCount){
                if($aTagCount&&$aTag->frequency<=1){
                    $aTag->delete();
                }
                else{
                    $aTag->frequency -=1;
                    $aTag->save();
                }
            }
        }
    }
    //更新标签的操作
    public static function updateFrequency($oldTags,$newTags){
        if(!empty($oldTags) || !empty($newTags)){
            $oldTagsArray = self::string2array($oldTags);
            $newTagsArray = self::string2array($newTags);

            self::addTags(array_values(array_diff($newTagsArray,$oldTagsArray)));
            self::removeTags(array_values(array_diff($oldTagsArray,$newTagsArray)));
        }
    }
    //生成标签云小部件所需的数据
    public static function findTagWeights($limit=20){
        $tag_size_level = 5;

        $models=Tags::find()->orderBy('frequency desc')->limit($limit)->all();
        $total=Tags::find()->limit($limit)->count();

        $stepper=ceil($total/$tag_size_level);

        $tags=array();
        $counter=1;

        if($total>0){
            foreach ($models as $model ){
                $weight=ceil($counter / $stepper)+1;
                $tags[$model->name]=$weight;
                $counter++;
            }
            ksort($tags);
        }
        return $tags;
    }
}
