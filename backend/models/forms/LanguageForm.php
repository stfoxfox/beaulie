<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Language;
/**
* This is the model class for Language form.
*/
class LanguageForm extends Model
{
    public $code;
    public $title;
    public $is_active;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['code'], 'string', 'max' => 2],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @param Language $item
     */
    public function loadFromItem($item)
    {
        $this->code = $item->code;
        $this->title = $item->title;
        $this->is_active = $item->is_active;
    }

    /**
     * @inheritdoc
     * @var Language $item
     */
    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->code = $this->code;
        $item->title = $this->title;
        $item->is_active = $this->is_active;
    
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

        $item = new Language();

        $item->code = $this->code;
        $item->title = $this->title;
        $item->is_active = $this->is_active;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
