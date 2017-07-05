<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Post;


/**
 * PostSearch represents the model behind the search form about `common\models\Post`.
 */
class PostSearch extends Post
{

    //给模型类增加属性：
    public function attributes(){
        return array_merge(parent::attributes(),['authorName','tagsName']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'post_status_id', 'update_time', 'create_time', 'author_id'], 'integer'],
            [['title', 'content', 'tags','authorName','tagsName'], 'safe'],
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
        $query = Post::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>['pageSize'=>5],
            'sort'=>['defaultOrder'=>['post_id'=>SORT_DESC],'attributes'=>['post_id','title']]
        ]);

        $this->load($params);   //把表单中填写的数据赋值到当前对象填写的属性

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'post_id' => $this->post_id,
            'post_status_id' => $this->post_status_id,
            'update_time' => $this->update_time,
            'create_time' => $this->create_time,
            'author_id' => $this->author_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'tags', $this->tags]);
        //设置关联查询
        $query->join('INNER JOIN','Adminuser','post.author_id=Adminuser.author_id');
        $query->andFilterWhere(['like','Adminuser.name',$this->authorName]);
        //设置排序
        $dataProvider->sort->attributes['authorName']=['asc'=>['Adminuser.name'=>SORT_ASC],'desc'=>['Adminuser.name'=>SORT_DESC]];

        return $dataProvider;
    }
}
