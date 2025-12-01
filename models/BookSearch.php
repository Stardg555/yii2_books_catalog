<?php

namespace app\models;


use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;


class BookSearch extends Books
{
    public $autor_name;
    public $autor_id;  

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'year'], 'integer'],
            [['title', 'description', 'isbn', 'author_name', 'autor_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'autor_name' => 'ФИО Автора',
            'autor_id' => 'ID Автора',
        ]);
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
        $query = Books::find()->joinWith(['autors']);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['title' => SORT_ASC],
                'attributes' => [
                    'id',
                    'title',
                    'year',
                    'isbn',
                    'autor_name' => [
                        'asc' => ['autors.fio' => SORT_ASC],
                        'desc' => ['autors.fio' => SORT_DESC],
                    ],
                ],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);


        $query->andFilterWhere([
            'books.id' => $this->id,
            'books.year' => $this->year,
        ]);

        $query->andFilterWhere(['like', 'books.title', $this->title])
            ->andFilterWhere(['like', 'books.description', $this->description])
            ->andFilterWhere(['like', 'books.isbn', $this->isbn]);


        if ($this->autor_id) {
            $query->andWhere(['autors.id' => $this->autor_id]);
        }

        if ($this->autor_name) {
            $query->andFilterWhere(['like', 'autors.full_name', $this->autor_name]);
        }

        $query->groupBy('books.id');

        return $dataProvider;
    }

    /**
     * @return array
     */
    public function getAutorsList()
    {
        return ArrayHelper::map(
            Author::find()->orderBy('fio')->all(),
            'id',
            'fio'
        );
    }

    /**
       * @return array
     */
    public function getYearsList()
    {
        $years = Books::find()
            ->select('year')
            ->distinct()
            ->orderBy(['year' => SORT_DESC])
            ->asArray()
            ->all();

        return ArrayHelper::map($years, 'year', 'year');
    }
}