<?php

use yii\db\Migration;

class m180219_080606_create_category_shop extends Migration
{
    public function up()
    {

        $this->createTable('{{%catalog_category_department}}', [
            'catalog_category_id' => $this->integer()->notNull(),
            'department_id' => $this->integer()->notNull(),
            'PRIMARY KEY(catalog_category_id, department_id)'
        ]);

        

        $this->addForeignKey(
            'catalog_category_department-catalog_category_id-fkey', 
            'catalog_category_department', 
            'catalog_category_id', 
            'catalog_category', 
            'id', 
            'CASCADE', 
            'CASCADE'
        );

        $this->addForeignKey(
            'catalog_category_department-department_id-fkey', 
            'catalog_category_department', 
            'department_id', 
            'department', 
            'id', 
            'CASCADE', 
            'CASCADE'
        );
    }

    public function down()
    {
        //$this->dropForeignKey('{{%catalog_category_department}}', 'catalog_category_department-catalog_category_id-fkey');
        //$this->dropForeignKey('{{%catalog_category_department}}', 'catalog_category_department-department_id-fkey');
        $this->dropTable('{{%catalog_category_department}}');
    }

}
