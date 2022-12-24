<?php

use yii\db\Migration;

/**
 * Class m221222_175610_create_table_languages
 */
class m221222_175610_create_table_languages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%languages}}', [
            'id'       => $this->primaryKey(),
            'language' => $this->string(4)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221222_175610_create_table_languages cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221222_175610_create_table_languages cannot be reverted.\n";

        return false;
    }
    */
}
