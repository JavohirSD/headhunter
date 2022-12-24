<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%positions_to_resume}}`.
 */
class m221222_174750_create_positions_to_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%positions_to_resume}}', [
            'id'          => $this->primaryKey(),
            'resume_id'   => $this->integer()->notNull(),
            'position_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-positions_to_resume1',
            'positions_to_resume',
            'resume_id',
            'resume',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-positions_to_resume2',
            'positions_to_resume',
            'position_id',
            'positions',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%positions_to_resume}}');
    }
}
