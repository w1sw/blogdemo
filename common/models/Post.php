<?php

namespace common\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "post".
 *
 * @property integer $post_id
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property integer $post_status_id
 * @property integer $update_time
 * @property integer $create_time
 * @property integer $author_id
 *
 * @property Comment[] $comments
 * @property Adminuser $author
 * @property Poststatus $postStatus
 */
class Post extends \yii\db\ActiveRecord
{
    public $_oldTags;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'tags'], 'string'],
            [['post_status_id', 'update_time', 'create_time', 'author_id'], 'integer'],
            [['title'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'tags' => '标签',
            'post_status_id' => '状态',
            'update_time' => '修改时间',
            'create_time' => '创建时间',
            'author_id' => '作者',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'post_id']);
    }

    public function getActiveComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'post_id'])->where('comment_status_id=:comment_status_id',[':comment_status_id'=>2])->orderBy('comment_id');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Adminuser::className(), ['author_id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostStatus()
    {
        return $this->hasOne(Poststatus::className(), ['post_status_id' => 'post_status_id']);
    }
    //重写保存前操作，在保存前就已经设定好时间
    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            if($insert){
                $this->create_time=time();
                $this->update_time=time();
            }
            else{
                $this->update_time=time();
            }
            return true;
        }else{
            return false;
        }
    }
    //重写保存后操作，来完成标签修改
    public function afterFind(){
        parent::afterFind();
        $this->_oldTags = $this->tags;
    }
    public function afterSave($insert , $changedAttributes){
        parent::afterSave($insert,$changedAttributes);
        Tags::updateFrequency($this->_oldTags,$this->tags);
    }
    public function afterDelete(){
        parent::afterDelete();
        Tags::updateFrequency($this->_oldTags,'');
    }

    //给标题写url
    public function getUrl(){
        return Yii::$app->urlManager->createUrl(
            ['post/detail','id'=>$this->post_id,'title'=>$this->title]);
    }
    //前台列表获取内容
    public function getBeginning($length=288){
        $tmpStr = strip_tags($this->content);
        $tmpLen = mb_strlen($tmpStr);

        $tmpStr = mb_substr($tmpStr,0,$length,'utf-8');
        return $tmpStr.($tmpLen>$length?'...':'');
    }
    //获取标签
    public function getTagLinks(){
        $links=array();
        foreach(Tags::string2array($this->tags) as $tag){
            $links[] = Html::a(Html::encode($tag),array('post/index','PostSearch[tags]'=>$tag));
        }
        return $links;
    }
    //获取评论条数
    public function getCommentCount(){
        return Comment::find()->where(['post_id'=>$this->post_id,'comment_status_id'=>2])->count();
}
}
