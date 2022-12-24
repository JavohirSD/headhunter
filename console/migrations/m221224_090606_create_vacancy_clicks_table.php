<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vacancy_clicks}}`.
 */
class m221224_090606_create_vacancy_clicks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vacancy_clicks}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'vacancy_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('NOW()'),
        ]);

        $this->createIndex('idx_unique_clicks',
            'vacancy_views',
            ['vacancy_id', 'user_id'],
            true);


        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-vacancy_clicks1',
            'vacancy_clicks',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-vacancy_clicks2',
            'vacancy_clicks',
            'vacancy_id',
            'vacancy',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vacancy_clicks}}');
    }
}
