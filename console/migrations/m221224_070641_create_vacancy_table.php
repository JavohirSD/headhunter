<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vacancy}}`.
 */
class m221224_070641_create_vacancy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vacancy}}', [
            'id'          => $this->primaryKey(),
            'title'       => $this->string(255)->notNull(),
            'position_id' => $this->integer()->notNull(),
            'salary'      => $this->integer()->notNull(),
            'salary_unit' => $this->tinyInteger()->notNull(),
            'user_id'     => $this->integer()->notNull(),
            'schedule'    => $this->string(255)->notNull(),
            'created_at'  => $this->timestamp()->defaultExpression('NOW()'),
            'updated_at'  => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE NOW()'),
        ]);


        $this->createIndex(
            'idx-vacancy-user_id',
            'vacancy',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-vacancy-user_id',
            'vacancy',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vacancy}}');
    }
}
