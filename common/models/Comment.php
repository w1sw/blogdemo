<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property integer $comment_id
 * @property string $content
 * @property integer $comment_status_id
 * @property integer $create_time
 * @property integer $userid
 * @property string $email
 * @property string $url
 * @property integer $post_id
 *
 * @property Post $post
 * @property Commentstatus $commentStatus
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['comment_status_id', 'create_time', 'userid', 'post_id'], 'integer'],
            [['email', 'url'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comment_id' => 'ID',
            'content' => '内容',
            'comment_status_id' => '状态',
            'create_time' => '时间',
            'userid' => '用户',
            'email' => '邮箱',
            'url' => 'Url',
            'post_id' => '对应文章',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['post_id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommentStatus()
    {
        return $this->hasOne(Commentstatus::className(), ['comment_status_id' => 'comment_status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }
    //Getter方法
    public function getBegining(){
        $tempStr = strip_tags($this->content);
        $tempLen = mb_strlen($tempStr);
        return mb_substr($tempStr,0,20,'utf-8').(($tempLen>20 )?'...':'');
    }
    //实现审核的业务需求
    public function approve(){
        $this->comment_status_id = 2;  //设置评论状态为已审核
        return ($this->save()?true:false);
    }
    //获取未审核的评论数
    public static function getUnauditedCount(){
        $query = Comment::find();
        $count = $query->where(['comment_status_id'=>1])->count();
        return $count;
    }
    //重写保存前操作，在保存前就已经设定好时间
    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            if($insert){
                $this->create_time=time();
            }
            return true;
        }else{
            return false;
        }
    }
    //获取最新评论
    public static function findRecentComments($limit=10){
        $recentComments = Comment::find()->where(['comment_status_id'=>2])->orderBy('create_time desc')->limit($limit)->all();
        return $recentComments;
    }
}
