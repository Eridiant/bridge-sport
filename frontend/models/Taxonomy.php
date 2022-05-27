<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%taxonomy}}".
 *
 * @property int $id
 * @property string|null $label
 * @property string|null $attr_key
 * @property int|null $value
 *
 * @property PostTaxonomy[] $postTaxonomies
 * @property Post[] $posts
 */
class Taxonomy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%taxonomy}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'integer'],
            [['label', 'attr_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => 'Label',
            'attr_key' => 'Attr Key',
            'value' => 'Value',
        ];
    }

    /**
     * Gets query for [[PostTaxonomies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostTaxonomies()
    {
        return $this->hasMany(PostTaxonomy::className(), ['taxonomy_id' => 'id']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['id' => 'post_id'])->viaTable('{{%post_taxonomy}}', ['taxonomy_id' => 'id']);
    }
}
