<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "subscribe_to_autors".
 *
 * @property int $id
 * @property string $email
 * @property string|null $phone
 * @property int $autor_id
 *
 * @property Autors $autor
 */
class SubscribeToAutors extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscribe_to_autors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone'], 'default', 'value' => null],
            [['email', 'autor_id'], 'required'],
            [['autor_id'], 'integer'],
            [['email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['email', 'autor_id'], 'unique', 'targetAttribute' => ['email', 'autor_id']],
            [['autor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Autors::class, 'targetAttribute' => ['autor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'autor_id' => 'Autor ID',
        ];
    }

    /**
     * Gets query for [[Autor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAutor()
    {
        return $this->hasOne(Autors::class, ['id' => 'autor_id']);
    }

}
