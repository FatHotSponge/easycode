<?php

namespace app\models;

use Yii;

use app\models\Tag;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $text
 * @property string $date_creation
 *
 * @property Category $category
 */
class Post extends \yii\db\ActiveRecord
{
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
            [['category_id'], 'required'],
            [['category_id'], 'integer'],
            [['text'], 'string'],
            [['date_creation'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'title' => 'Title',
            'text' => 'Text',
            'date_creation' => 'Date Creation'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('post_tag', ['post_id' => 'id']);
    }

    /**
     * Returns imploded post tags names.
     *
     * @return string
     */
    public function getImplodedTags() {
        $tags = [];
        foreach ($this->tags as $tag) {
            $tags[] = $tag->name;
        }

        return implode(',', $tags);
    }
}
