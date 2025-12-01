<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $title
 * @property int $year
 * @property string|null $description
 * @property string|null $isbn
 * @property string|null $cover_image
 *
 * @property Autors[] $autors
 * @property BooksAutors[] $booksAutors
 */
class Books extends ActiveRecord
{

    public $autorIds = [];
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
    }

    public function behaviors() {
        return [
            'notification' => [
                'class' => \app\behaviors\NewBookNotificationBehavior::class,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'isbn', 'cover_image'], 'default', 'value' => null],
            [['title', 'year'], 'required'],
            [['year'], 'integer', 'min' => 0, 'max' => date('Y')],
            [['description'], 'string'],
            [['title', 'cover_image'], 'string', 'max' => 255],
            [['isbn'], 'string', 'min' => 13, 'max' => 13],
            [['autorIds'], 'safe'],
            [['cover_image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название книги',
            'year' => 'Год издания',
            'description' => 'Описание',
            'isbn' => 'ISBN',
            'cover_image' => 'Обложка',
        ];
    }

    /**
     * Gets query for [[Autors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAutors()
    {
        return $this->hasMany(Autors::class, ['id' => 'autors_id'])->viaTable('books_autors', ['books_id' => 'id']);
    }

    /**
     * Gets query for [[BooksAutors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooksAutors()
    {
        return $this->hasMany(BooksAutors::class, ['books_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->handleImageUpload();
            return true;
        }
        return false;
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        
        if ($this->autorIds !== null) {
            BooksAutors::deleteAll(['books_id' => $this->id]);
            
            foreach ([$this->autorIds] as $autor_id) {
                $bookAutor = new BooksAutors();
                $bookAutor->books_id = $this->id;
                $bookAutor->autors_id = $autor_id;
                $bookAutor->save();
            }
        }
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->autorIds = $this->getAutors()->select('id')->column();
    }

    private function handleImageUpload()
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        
        if ($this->imageFile) {
            $uploadPath = Yii::getAlias('@webroot/uploads/books/covers/');
            FileHelper::createDirectory($uploadPath);
            
            $fileName = uniqid() . '_' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $filePath = $uploadPath . $fileName;
            
            if ($this->imageFile->saveAs($filePath)) {
                
                if ($this->cover_image && file_exists(Yii::getAlias('@webroot') . $this->cover_image)) {
                    unlink(Yii::getAlias('@webroot') . $this->cover_image);
                }
                $this->cover_image = '/uploads/books/covers/' . $fileName;
            }
        }
    }
    
    public function getAutorsNames()
    {
        return implode(', ', $this->getAutors()->select('fio')->column());
    }
}
