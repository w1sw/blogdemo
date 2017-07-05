<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AuthItemChild;

/**
 * AuthItemChildSearch represents the model behind the search form about `common\models\AuthItemChild`.
 */
class AuthItemChildSearch extends AuthItemChild
{

    //给模型类增加属性：
    public function attributes(){
        return array_merge(parent::attributes(),['allow']);
    }
    /**
     * @inheritdoc用于提供检索
     */
    public function rules()
    {
        return [
            [['parent','child','allow'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AuthItemChild::find()->groupBy('parent');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>['pageSize'=>5],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'parent', $this->parent])
            ->andFilterWhere(['like', 'child', $this->child]);
        //设置关联查询
        $query->join('INNER JOIN','Auth_Item','Auth_Item_Child.child=Auth_Item.name');
        $query->andFilterWhere(['like','Auth_Item.description',$this->allow]);
        return $dataProvider;
    }

}
