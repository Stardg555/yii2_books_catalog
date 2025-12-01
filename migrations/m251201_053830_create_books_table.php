<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m251201_053830_create_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'year' => $this->integer(4)->notNull(),
            'description' => $this->text(),
            'isbn' => $this->string(13),
            'cover_image' => $this->string(255),
        ]);

        $this->createIndex('idx_books_title', '{{%books}}', 'title');
        $this->createIndex('idx_books_year', '{{%books}}', 'year');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%books}}');
    }
}
