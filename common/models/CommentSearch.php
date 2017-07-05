<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Comment;

/**
 * CommentSearch represents the model behind the search form about `common\models\Comment`.
 */
class CommentSearch extends Comment
{
    public function attributes(){
        return array_merge(parent::attributes(),['user.username','post.title']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment_id', 'comment_status_id', 'create_time', 'userid', 'post_id'], 'integer'],
            [['content', 'email', 'url','user.username','post.title'], 'safe'],
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
        $query = Comment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'comment_id' => $this->comment_id,
            'comment_status_id' => $this->comment_status_id,
            'create_time' => $this->create_time,
            'userid' => $this->userid,
            'post_id' => $this->post_id,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'url', $this->url]);

        $query->join('INNER JOIN','CommentStatus','Comment.comment_status_id=CommentStatus.comment_status_id');
        $query->join('INNER JOIN','post','Comment.post_id=post.post_id');
        $query->andFilterWhere(['like','post.title',$this->getAttribute('post.title')]);

        $dataProvider->sort->defaultOrder = [
            'comment_status_id'=>SORT_ASC,
            'comment_id'=>SORT_DESC
        ];

        return $dataProvider;
    }
}
