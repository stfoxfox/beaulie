<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Country;
/**
* This is the model class for Country form.
*/
class CountryForm extends Model
{
    public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @param Country $item
     */
    public function loadFromItem($item)
    {
        $this->name = $item->name;
    }

    /**
     * @inheritdoc
     * @var Country $item
     */
    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->name = $this->name;
    
        if ($item->save()) {
            return true;
        }

        return null;
    }

    public function create()
    {
        if (!$this->validate()) {
            return null;
        }

        $item = new Country();

        $item->name = $this->name;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
