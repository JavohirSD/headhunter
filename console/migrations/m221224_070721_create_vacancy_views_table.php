<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vacancy_views}}`.
 */
class m221224_070721_create_vacancy_views_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vacancy_views}}', [
            'id'         => $this->primaryKey(),
            'vacancy_id' => $this->integer(),
            'user_id'    => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression('NOW()'),
        ]);

        $this->createIndex('idx_unique_views',
            'vacancy_views',
            ['vacancy_id', 'user_id'],
            true);


        $this->addForeignKey(
            'fk_vacancy_views1',
            'vacancy_views',
            'vacancy_id',
            'vacancy',
            'id');


        $this->addForeignKey(
            'fk_vacancy_views2',
            'vacancy_views',
            'user_id',
            'user',
            'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vacancy_views}}');
    }
}
