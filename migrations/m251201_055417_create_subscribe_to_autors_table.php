<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscribe_to_autors}}`.
 */
class m251201_055417_create_subscribe_to_autors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscribe_to_autors}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string(255)->notNull(),
            'phone' => $this->string(20),
            'autor_id' => $this->integer()->notNull(),
        ]);
        
        $this->addForeignKey(
            'fk_subscribe_to_autors',
            '{{%subscribe_to_autors}}',
            'autor_id',
            '{{%autors}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('idx_subscribe_to_autors_email_autor', '{{%subscribe_to_autors}}', ['email', 'autor_id'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%subscribe_to_autors}}');
    }
}
