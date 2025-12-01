<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books_autors}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%books}}`
 * - `{{%autors}}`
 */
class m251201_055003_create_junction_table_for_books_and_autors_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books_autors}}', [
            'books_id' => $this->integer(),
            'autors_id' => $this->integer(),
            'PRIMARY KEY(books_id, autors_id)',
        ]);

        // creates index for column `books_id`
        $this->createIndex(
            '{{%idx-books_autors-books_id}}',
            '{{%books_autors}}',
            'books_id'
        );

        // add foreign key for table `{{%books}}`
        $this->addForeignKey(
            '{{%fk-books_autors-books_id}}',
            '{{%books_autors}}',
            'books_id',
            '{{%books}}',
            'id',
            'CASCADE'
        );

        // creates index for column `autors_id`
        $this->createIndex(
            '{{%idx-books_autors-autors_id}}',
            '{{%books_autors}}',
            'autors_id'
        );

        // add foreign key for table `{{%autors}}`
        $this->addForeignKey(
            '{{%fk-books_autors-autors_id}}',
            '{{%books_autors}}',
            'autors_id',
            '{{%autors}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%books}}`
        $this->dropForeignKey(
            '{{%fk-books_autors-books_id}}',
            '{{%books_autors}}'
        );

        // drops index for column `books_id`
        $this->dropIndex(
            '{{%idx-books_autors-books_id}}',
            '{{%books_autors}}'
        );

        // drops foreign key for table `{{%autors}}`
        $this->dropForeignKey(
            '{{%fk-books_autors-autors_id}}',
            '{{%books_autors}}'
        );

        // drops index for column `autors_id`
        $this->dropIndex(
            '{{%idx-books_autors-autors_id}}',
            '{{%books_autors}}'
        );

        $this->dropTable('{{%books_autors}}');
    }
}
