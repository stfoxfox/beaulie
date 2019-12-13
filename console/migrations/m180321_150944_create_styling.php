<?php

use yii\db\Migration;

/**
 * Class m180321_150944_create_styling
 */
class m180321_150944_create_styling extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('styling', [
            'id' => $this->primaryKey(),
            'file_id' => $this->integer(),
            'category_id' => $this->integer(),
            'image_id' => $this->integer(),
            'title_ru' => $this->string(),
            'title_en' => $this->string(),
            'title_kz' => $this->string(),
            'title_ua' => $this->string(),
            'title_by' => $this->string(),
            'subtitle_ru' => $this->string(),
            'subtitle_en' => $this->string(),
            'subtitle_kz' => $this->string(),
            'subtitle_ua' => $this->string(),
            'subtitle_by' => $this->string(),
            'text_ru' => $this->text(),
            'text_en' => $this->text(),
            'text_kz' => $this->text(),
            'text_ua' => $this->text(),
            'text_by' => $this->text(),
            'sort' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp()
        ]);

        $this->createIndex('styling-file_id-idx', 'styling', 'file_id');
        $this->createIndex('styling-image_id-idx', 'styling', 'image_id');
        $this->createIndex('styling-category_id-idx', 'styling', 'category_id');

        $this->addForeignKey('styling-file_id-idx', 'styling', 'file_id', 'file', 'id', 'CASCADE', 'SET NULL');
        $this->addForeignKey('styling-image_id-idx', 'styling', 'image_id', 'file', 'id', 'CASCADE', 'SET NULL');
        $this->addForeignKey('styling-category_id-idx', 'styling', 'category_id', 'catalog_category', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('styling');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180321_150944_create_styling cannot be reverted.\n";

        return false;
    }
    */
}
