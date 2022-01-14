<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%post_taxonomy}}".
 *
 * @property int $post_id
 * @property int $taxonomy_id
 *
 * @property Post $post
 * @property Taxonomy $taxonomy
 */
class PostTaxonomy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%post_taxonomy}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'taxonomy_id'], 'required'],
            [['post_id', 'taxonomy_id'], 'integer'],
            [['post_id', 'taxonomy_id'], 'unique', 'targetAttribute' => ['post_id', 'taxonomy_id']],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['taxonomy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Taxonomy::className(), 'targetAttribute' => ['taxonomy_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'taxonomy_id' => 'Taxonomy ID',
        ];
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    /**
     * Gets query for [[Taxonomy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaxonomy()
    {
        return $this->hasOne(Taxonomy::className(), ['id' => 'taxonomy_id']);
    }
}
