<?php

namespace app\models;

use Yii\db\ActiveRecord;

/**
 * This is the model class for table "books_autors".
 *
 * @property int $books_id
 * @property int $autors_id
 *
 * @property Autors $autors
 * @property Books $books
 */
class BooksAutors extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books_autors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['books_id', 'autors_id'], 'required'],
            [['books_id', 'autors_id'], 'integer'],
            [['books_id', 'autors_id'], 'unique', 'targetAttribute' => ['books_id', 'autors_id']],
            [['autors_id'], 'exist', 'skipOnError' => true, 'targetClass' => Autors::class, 'targetAttribute' => ['autors_id' => 'id']],
            [['books_id'], 'exist', 'skipOnError' => true, 'targetClass' => Books::class, 'targetAttribute' => ['books_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'books_id' => 'Books ID',
            'autors_id' => 'Autors ID',
        ];
    }

    /**
     * Gets query for [[Autors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAutors()
    {
        return $this->hasOne(Autors::class, ['id' => 'autors_id']);
    }

    /**
     * Gets query for [[Books]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasOne(Books::class, ['id' => 'books_id']);
    }

}
