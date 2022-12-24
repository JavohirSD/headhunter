<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%positions}}`.
 */
class m221222_174613_create_positions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%positions}}', [
            'id'         => $this->primaryKey(),
            'title'      => $this->string(255)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('NOW()'),
            'status'     => $this->tinyInteger(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%positions}}');
    }
}
