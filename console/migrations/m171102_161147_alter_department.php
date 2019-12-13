<?php

use yii\db\Migration;

class m171102_161147_alter_department extends Migration
{
    public function safeUp()
    {
        $this->execute("ALTER TABLE department ALTER COLUMN lat DROP NOT NULL ");
        $this->execute("ALTER TABLE department ALTER COLUMN lng DROP NOT NULL ");
    }

    public function safeDown()
    {
        return true;
    }
}
