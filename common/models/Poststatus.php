<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "poststatus".
 *
 * @property integer $post_status_id
 * @property string $name
 * @property string $poistion
 *
 * @property Post[] $posts
 */
class Poststatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'poststatus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 128],
            [['poistion'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_status_id' => 'Post Status ID',
            'name' => 'Name',
            'poistion' => 'Poistion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['post_status_id' => 'post_status_id']);
    }
}
