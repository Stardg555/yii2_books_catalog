<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%autors}}`.
 */
class m251201_053809_create_autors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%autors}}', [
            'id' => $this->primaryKey(),
            'fio' => $this->string(255)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%autors}}');
    }
}
