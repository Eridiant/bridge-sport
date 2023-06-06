<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Post;

/**
 * PostSearch represents the model behind the search form of `frontend\models\Post`.
 */
class PostSearch extends Post
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'parent_id', 'image_id', 'iframe_id', 'indexing', 'status', 'author_id', 'published_at', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['name', 'url', 'slug', 'preview', 'text', 'dial', 'title', 'description', 'keywords'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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

        if ($params && isset($params["category_id"])) {
            $this->category_id = $params["category_id"];
        }

        $query = Post::find()->with(['image', 'taxonomies', 'category', 'iframe']);

        // $model = Survey::find();

        // $query->union($model);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'published_at' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'parent_id' => $this->parent_id,
            'image_id' => $this->image_id,
            'iframe_id' => $this->iframe_id,
            'indexing' => $this->indexing,
            'status' => $this->status,
            'author_id' => $this->author_id,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['in', 'category_id', $this->category_id])
            ->andFilterWhere(['>', 'status', 9])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'preview', $this->preview])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'dial', $this->dial])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'keywords', $this->keywords]);

        return $dataProvider;
    }
}
