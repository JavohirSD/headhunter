<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%resume}}`.
 */
class m221222_173832_create_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%resume}}', [
            'id'           => $this->primaryKey(),
            'user_id'      => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('NOW()'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE NOW()'),
            'avatar'       => $this->string(255)->notNull(),
            'job_duration' => $this->integer()->notNull(),
            'salary'       => $this->integer()->notNull(),
            'salary_unit'  => $this->tinyInteger()->notNull(),
            'phone'        => $this->string(16)->notNull(),
            'website'      => $this->string(255)->defaultValue(null),
            'status'       => $this->tinyInteger()->defaultValue(1),
        ]);

        $this->createIndex(
            'idx-resume-user_id',
            'resume',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-resume-user_id',
            'resume',
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
        $this->dropTable('{{%resume}}');
    }
}
