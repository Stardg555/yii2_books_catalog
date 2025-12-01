<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ReportsHelper extends Model
{
    public $year;

    public function rules()
    {
        return [
            [['year'], 'required'],
            [['year'], 'integer', 'min' => 1000, 'max' => date('Y')],
        ];
    }

    public function attributeLabels()
    {
        return [
            'year' => 'Год',
        ];
    }

    public static function getTopTenAutors($year)
    {
        return Autors::find()
            ->select([
                'autors.*',
                'COUNT(books_autors.books_id) as book_count'
            ])
            ->innerJoin('books_autors', 'books_autors.autors_id = autors.id')
            ->innerJoin('books', 'books.id = books_autors.books_id')
            ->where(['books.year' => $year])
            ->groupBy('autors.id')
            ->orderBy(['book_count' => SORT_DESC])
            ->limit(10)
            ->all();
    }
}
