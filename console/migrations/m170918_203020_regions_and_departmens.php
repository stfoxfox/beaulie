<?php

use yii\db\Migration;

class m170918_203020_regions_and_departmens extends Migration
{
    public function safeUp()
    {


        $this->createTable('region',[
            'id'=>$this->primaryKey(),
            'title'=>$this->string(),
            'sort'=>$this->integer()->defaultValue(0),
            'created_at'=>$this->timestamp()->defaultExpression("now()"),
            'updated_at'=>$this->timestamp()->defaultExpression("now()")
        ]);



        $this->createTable('department', [
            'id' => $this->primaryKey(),
            'title'=>$this->string()->notNull(),
            'address'=>$this->string(),
            'region_id'=>$this->integer(),
            'phone'=>$this->string(),
            'phone_2'=>$this->string(),
            'site_url'=>$this->string(),
            'lat'=>'double  NOt NULL',
            'lng'=>'double  NOt NULL',
            'sort'=>$this->integer()->defaultValue(0),
            'is_active'=>$this->boolean()->defaultValue(false),
            'created_at'=>$this->timestamp()->defaultExpression("now()"),
            'updated_at'=>$this->timestamp()->defaultExpression("now()"),

        ]);


        $this->addForeignKey('department-region_id-fkey','department','region_id','region','id','SET NULL','CASCADE');

        $this->createTable('working_days',
            array(

                'id'=>$this->primaryKey(),
                'weekday'=>$this->smallInteger()->notNull(),
                'status'=>$this->smallInteger()->notNull(),
                'created_at'=>$this->timestamp()->defaultExpression("now()"),
                'updated_at'=>$this->timestamp()->defaultExpression("now()")

            ));



        $this->createTable('working_hours', array(
            'id'=>$this->primaryKey(),
            'open_time'=>$this->time(),
            'close_time'=>$this->time(),
            'type'=>$this->smallInteger()->notNull()->defaultValue(1),
            'created_at'=>$this->timestamp()->defaultExpression("now()"),
            'updated_at'=>$this->timestamp()->defaultExpression("now()")
        ));


        $this->addColumn('working_days','department_id',$this->integer()->notNull());

        $this->addForeignKey('working_days-restaurant_id-fkey','working_days','department_id','department','id','CASCADE','CASCADE');



        $this->addColumn('working_hours','working_day_id',$this->integer());

        $this->addForeignKey('working_hours_working_day_id_fkey','working_hours','working_day_id','working_days','id','CASCADE','CASCADE');


        $this->createIndex('working_hours-working_day_id-idx','working_hours','working_day_id');
        $this->createIndex('working_days-department_id-idx','working_days','department_id');



    }

    public function safeDown()
    {
        echo "m170918_203020_regions_and_departmens cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170918_203020_regions_and_departmens cannot be reverted.\n";

        return false;
    }
    */
}
