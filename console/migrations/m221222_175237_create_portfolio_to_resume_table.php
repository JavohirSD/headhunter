<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%portfolio_to_resume}}`.
 */
class m221222_175237_create_portfolio_to_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%portfolio_to_resume}}', [
            'id'        => $this->primaryKey(),
            'file'      => $this->string(255)->notNull(),
            'resume_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-portfolio_to_resume-resume_id',
            'portfolio_to_resume',
            'resume_id'
        );

        // add foreign key for table `resume`
        $this->addForeignKey(
            'fk-portfolio_to_resume-resume_id',
            'portfolio_to_resume',
            'resume_id',
            'resume',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%portfolio_to_resume}}');
    }
}
