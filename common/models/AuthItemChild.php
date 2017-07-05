<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "auth_item_child".
 *
 * @property string $parent
 * @property string $child
 *
 * @property AuthItem $parent0
 * @property AuthItem $child0
 */
class AuthItemChild extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_item_child';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent' => '角色',
            'child' => '权限',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent0()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChild0()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'child']);
    }
    //数组转成字符串
    public static function array2string($jurisdiction){
        return implode(',',$jurisdiction);
    }
    //获取角色的权限
    public function getJurisdiction(){
        $jur=array();
        $query = AuthItemChild::find();
        $jurisdiction=$query->where(['parent'=>$this->parent])->asArray()->all();
        $obj=new AuthItem();    //用于查找权限的名称
        foreach ($jurisdiction as $row){
            //查到子权限后，再从表authitem中查找中文名称
            $res=$obj->find()->where(['name'=>$row['child']])->asArray()->one();
            $jur['allow'][]=$res['description'];
        }
        $allow=AuthItemChild::array2string($jur['allow']);
        return $allow;
    }

}
