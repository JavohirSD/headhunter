<?php

use yii\db\Migration;

/**
 * Class m221222_175627_create_table_languages_to_resume
 */
class m221222_175627_create_table_languages_to_resume extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%languages_to_resume}}', [
            'id'          => $this->primaryKey(),
            'language_id' => $this->integer()->notNull(),
            'resume_id'   => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-languages_to_resume1',
            'languages_to_resume',
            'resume_id'
        );

        $this->createIndex(
            'idx-languages_to_resume2',
            'languages_to_resume',
            'language_id'
        );

        // add foreign key for table `languages`
        $this->addForeignKey(
            'fk-language_resume_id1',
            'languages_to_resume',
            'language_id',
            'languages',
            'id',
            'CASCADE'
        );

        // add foreign key for table `resume`
        $this->addForeignKey(
            'fk-language_resume_id2',
            'languages_to_resume',
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
        echo "m221222_175627_create_table_languages_to_resume cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221222_175627_create_table_languages_to_resume cannot be reverted.\n";

        return false;
    }
    */
}
