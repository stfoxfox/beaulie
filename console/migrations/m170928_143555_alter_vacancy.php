<?php

use yii\db\Migration;

class m170928_143555_alter_vacancy extends Migration
{
    public function safeUp()
    {
        $this->addColumn('vacancy', 'department_ru', $this->string());
        $this->addColumn('vacancy', 'department_en', $this->string());
        $this->addColumn('vacancy', 'department_ua', $this->string());
        $this->addColumn('vacancy', 'department_kz', $this->string());
        $this->addColumn('vacancy', 'department_by', $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn('vacancy', 'department_ru');
        $this->dropColumn('vacancy', 'department_en');
        $this->dropColumn('vacancy', 'department_ua');
        $this->dropColumn('vacancy', 'department_kz');
        $this->dropColumn('vacancy', 'department_by');
    }
}
