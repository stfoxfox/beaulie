<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\PageBlock;
/**
* This is the model class for PageBlock form.
*/
class PageBlockForm extends Model
{
    public $page_id;
    public $type;
    public $sort;
    public $data;
    public $block_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'type', 'sort'], 'integer'],
            [['data'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['block_name'], 'string', 'max' => 255],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
        ];
    }

    /**
     * @param PageBlock $item
     */
    public function loadFromItem($item)
    {
        $this->page_id = $item->page_id;
        $this->type = $item->type;
        $this->sort = $item->sort;
        $this->data = $item->data;
        $this->block_name = $item->block_name;
    }

    /**
     * @inheritdoc
     * @var PageBlock $item
     */
    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->page_id = $this->page_id;
        $item->type = $this->type;
        $item->sort = $this->sort;
        $item->data = $this->data;
        $item->block_name = $this->block_name;
    
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

        $item = new PageBlock();

        $item->page_id = $this->page_id;
        $item->type = $this->type;
        $item->sort = $this->sort;
        $item->data = $this->data;
        $item->block_name = $this->block_name;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
