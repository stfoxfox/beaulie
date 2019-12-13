<?php

namespace backend\models\forms;

use common\models\Page;
use Yii;
use yii\base\Model;
use common\models\Collection;
/**
* This is the model class for Collection form.
*/
class CollectionForm extends Model
{
    public $title_ru;
    public $title_en;
    public $title_ua;
    public $title_kz;
    public $title_by;
    public $page_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_ru'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['page_id'], 'safe'],
            [['title_ru', 'title_en', 'title_ua', 'title_kz', 'title_by'], 'string', 'max' => 255],
        ];
    }

    /**
     * @param Collection $item
     */
    public function loadFromItem($item)
    {
        $this->title_ru = $item->title_ru;
        $this->title_en = $item->title_en;
        $this->title_ua = $item->title_ua;
        $this->title_kz = $item->title_kz;
        $this->title_by = $item->title_by;
        $this->page_id = $item->page_id;
    }

    /**
     * @inheritdoc
     * @var Collection $item
     */
    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->title_ru = $this->title_ru;
        $item->title_en = $this->title_en;
        $item->title_ua = $this->title_ua;
        $item->title_kz = $this->title_kz;
        $item->title_by = $this->title_by;

        if (!$item->page_id) {
            $this->createPageForItem($item);
        }

        if ($item->save()) {
            return true;
        }

        return null;
    }

    /**
     * @param Collection $item
     */
    protected function createPageForItem($item)
    {
        $page = new Page();
        $page->is_internal = true;
        $page->title_ru = $item->title_ru;
        $page->title_en = $item->title_en;
        $page->title_ua = $item->title_ua;
        $page->title_kz = $item->title_kz;
        $page->title_by = $item->title_by;

        $page->slug = 'collection_' . mb_strtolower($item->title_ru);

        if ($page->save()) {
            $item->page_id = $page->id;
        }
    }

    public function create()
    {
        if (!$this->validate()) {
            return null;
        }

        $item = new Collection();

        $item->title_ru = $this->title_ru;
        $item->title_en = $this->title_en;
        $item->title_ua = $this->title_ua;
        $item->title_kz = $this->title_kz;
        $item->title_by = $this->title_by;

        $this->createPageForItem($item);

        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
