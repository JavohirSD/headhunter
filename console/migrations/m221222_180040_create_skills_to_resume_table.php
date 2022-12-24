<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%skills_to_resume}}`.
 */
class m221222_180040_create_skills_to_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%skills_to_resume}}', [
            'id' => $this->primaryKey(),
            'skill_id' => $this->integer()->notNull(),
            'resume_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-skills_to_resume1',
            'skills_to_resume',
            'skill_id'
        );

        $this->createIndex(
            'idx-skills_to_resume2',
            'skills_to_resume',
            'resume_id'
        );

        // add foreign key for table `skills`
        $this->addForeignKey(
            'fk-skills_to_resume-skill_id',
            'skills_to_resume',
            'skill_id',
            'skills',
            'id',
            'CASCADE'
        );

        // add foreign key for table `resume`
        $this->addForeignKey(
            'fk-skills_to_resume-resume_id',
            'skills_to_resume',
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
        $this->dropTable('{{%skills_to_resume}}');
    }
}
