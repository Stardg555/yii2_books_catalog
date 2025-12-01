<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "autors".
 *
 * @property int $id
 * @property string $fio
 *
 * @property Books[] $books
 * @property BooksAutors[] $booksAutors
 * @property SubscribeToAutors[] $subscribeToAutors
 */
class Autors extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'autors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio'], 'required'],
            [['fio'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
        ];
    }

    /**
     * Gets query for [[Books]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Books::class, ['id' => 'books_id'])->viaTable('books_autors', ['autors_id' => 'id']);
    }

    /**
     * Gets query for [[BooksAutors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooksAutors()
    {
        return $this->hasMany(BooksAutors::class, ['autors_id' => 'id']);
    }

    /**
     * Gets query for [[SubscribeToAutors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubscribeToAutors()
    {
        return $this->hasMany(SubscribeToAutors::class, ['autor_id' => 'id']);
    }
    
    
    /**
     * Возвращает количество книг у автора
     * 
     * @return int
     */
    public function getBookCount():int
    {
        return $this->hasMany(BooksAutors::class, ['autors_id' => 'id'])->count();
    }

}
