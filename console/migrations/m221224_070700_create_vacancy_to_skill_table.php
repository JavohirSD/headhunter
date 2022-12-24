<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vacancy_to_skill}}`.
 */
class m221224_070700_create_vacancy_to_skill_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vacancy_to_skill}}', [
            'id'         => $this->primaryKey(),
            'vacancy_id' => $this->integer()->notNull(),
            'skill_id'   => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vacancy_to_skill}}');
    }
}
