<?php

namespace backend\models\forms;

use yii\base\Model;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use common\models\CatalogItem;
use common\models\Brand;
use common\models\Collection;
use common\models\Attribute;
use common\models\AttributeValue;
use PHPExcel_Cell;

class XlsxImportForm extends Model
{
    public $file;
    public $import_attributes = false;
    public $import_items = true;
    public $import_attribute_values = false;
    public $delete_not_updated = true;
    public $category_id;

    // import counters
    public $importedItemsCount;
    public $importedBrandsCount;
    public $importedCollectionsCount;
    public $importedAttributesCount;
    public $importedAttributeValuesCount;
    public $updatedItemsCount;
    public $deletedItemsCount;

    public $expectedColumns = ['бренд', 'коллекция', 'дизайн', 'расцветка'];
    public $nonAttributeColumns = ['бренд', 'коллекция', 'примерный уровень цены в рознице, руб. (тенге, гривны) за кв. м.'];
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['category_id'], 'required'],
            [['import_attributes', 'import_items', 'import_attribute_values', 'delete_not_updated'], 'boolean'],
            [['file'], 'file', 'extensions' => ['xlsx'], 'maxFiles' => 1]
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'file' => 'Файл для импорта',
            'import_items' => 'Импортировать новые объекты',
            'import_attributes' => 'Импортировать новые атрибуты',
            'import_attribute_values' => 'Импортировать новые значения селективных атрибутов',
            'delete_not_updated' => 'Удалить несуществующие товары'
        ];
    }

    /**
     * @return bool
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    public function import()
    {
        if (!$this->validate()) {
            return false;
        }

        $file = UploadedFile::getInstance($this, 'file');
        if ($file) {
            $reader = \PHPExcel_IOFactory::createReader('Excel2007');
            $reader->setReadDataOnly(true);
            $reader->setLoadAllSheets();

            $obj = $reader->load($file->tempName);

            $loadedSheetNames = $obj->getSheetNames();
            foreach($loadedSheetNames as $sheetIndex => $loadedSheetName) {
                $sheetData = $obj->getSheet($sheetIndex);

                $headerMap = $this->parseHeader($sheetData);

                if (!$this->checkHeaderMap($headerMap)) {
                    return false;
                }

                $attributes = $this->parseAttributes($headerMap, $sheetData, $this->import_attributes);
                $map = $this->parseCatalogItems($headerMap, $sheetData, $attributes);
                $this->saveItemsMap($map);
            }
        }
    }

    /**
     * @param int $index
     * @param $sheetData
     * @return int
     */
    protected function parseAttributeType($index, $sheetData)
    {
        $highestRow = $sheetData->getHighestRow();
        $colName = PHPExcel_Cell::stringFromColumnIndex($index);
        $colData = $sheetData->rangeToArray($colName . '3:' . $colName . $highestRow);

        foreach ($colData as $value) {
            if ($value[0] === 'да' || $value[0] === 'нет') {
                return Attribute::TYPE_BOOL;
            }

            if (is_string($value[0])) {
                return Attribute::TYPE_STRING;
            }

            if (is_numeric($value[0])) {
                return Attribute::TYPE_NUMBER;
            }
        }
    }

    /**
     * @param string $name
     * @param integer|boolean $type
     * @param bool $save
     * @return Attribute|static
     */
    protected function findOrCreateAttribute($name, $type = false, $save = false)
    {
        $attribute = Attribute::findOne(['ext_key' => $name]);
        if (!$attribute && $save && $type) {
            $attribute = new Attribute([
                'title_ru' => $name,
                'ext_key' => $name,
                'type' => $type,
                'show_in_collection' => false,
                'show_in_list' => false,
                'show_in_catalog_item' => false
            ]);
            $attribute->save();
            $this->importedAttributesCount++;
        }

        return $attribute;
    }

    /**
     * @param $sheetData
     * @return array
     */
    protected function parseHeader($sheetData)
    {
        $map = [];
        $highestCol = $sheetData->getHighestColumn();

        $rowData = $sheetData->rangeToArray('A2:' . $highestCol . '2', null, true, false);

        foreach ($rowData[0] as $index => $colName) {
            if (!empty($colName)) {
                $map[$index] = mb_strtolower(trim($colName));
            }
        }

        return $map;
    }

    /**
     * @param $map
     * @return bool
     */
    protected function checkHeaderMap($map)
    {
        foreach ($this->expectedColumns as $column) {
            if (!in_array($column, $map)) {
                $this->addError('file', 'В файле не найдены колонка: "' . $column . '"');
                return false;
            }
        }

        return true;
    }

    /**
     * @param $map
     * @param $sheetData
     * @param bool $save
     * @return Attribute[]|null
     */
    protected function parseAttributes($map, $sheetData, $save = false)
    {
        $attributes = null;

        foreach ($map as $index => $attributeName) {
            if (!in_array($attributeName, $this->nonAttributeColumns)) {
                $attributes[$index] = $this->findOrCreateAttribute(
                    $attributeName,
                    ($save ? $this->parseAttributeType($index, $sheetData) : false),
                    $save
                );
            }
        }

        return $attributes;
    }

    /**
     * @param $map array header map
     * @param $sheetData
     * @param null|array $attributes
     * @return array
     */
    protected function parseCatalogItems($map, $sheetData, $attributes = null)
    {
        $highestRow = $sheetData->getHighestRow();
        $highestCol = $sheetData->getHighestColumn();

        $items = [];
        for ($row = 3; $row <= $highestRow; $row++) {
            $rowData  = $sheetData->rangeToArray('A' . $row . ':' . $highestCol . $row, null, true, false);
            $itemData = $rowData[0];
            $items[$row]['title'] = '';

            foreach ($itemData as $key => $value) {
                if (!isset($map[$key])) continue;

                if ($map[$key] === 'бренд') { // brand
                    $brand = Brand::findOne(['title_ru' => $value]);
                    if (!$brand) {
                        $brand = new Brand(['title_ru' => $value]);
                        $brand->save();
                        $this->importedBrandsCount++;
                    }
                    $items[$row]['brand_id'] = $brand->id;
                } elseif ($map[$key] === 'коллекция') { // collection



                    $collection = Collection::findOne(['title_ru' => $value]);
                    if (!$collection) {
                        $collection = new Collection(['title_ru' => $value]);
                        $collection->save();
                        $this->importedCollectionsCount++;
                    }
                    $items[$row]['collection_id'] = $collection->id;
                } elseif ($map[$key] === 'дизайн') {
                    $items[$row]['title'] .= $value . ' ';
                } elseif ($map[$key] === 'расцветка') {
                    $items[$row]['title'] .= $value;
                } elseif ($map[$key] === 'ширины') {
                    $items[$row]['description'] = $value;
                } elseif ($map[$key] === 'примерный уровень цены в рознице, руб. (тенге, гривны) за кв. м.') {
                    $valueParts = explode('-', $value);
                    if (count($valueParts) === 2) { // price
                        $items[$row]['min_price'] = $valueParts[0];
                        $items[$row]['max_price'] = $valueParts[1];
                    }
                } elseif (isset($attributes[$key])) {
                    $items[$row]['attributes'][] = [
                        'id' => $attributes[$key]->id,
                        'type' => $attributes[$key]->type,
                        'value' => $value
                    ];
                }
            }
        }

        return $items;
    }

    /**
     * @param $items
     * @throws \yii\db\Exception
     */
    protected function saveItemsMap($items)
    {
        $itemIds = [];
        $catalogItemCategory = [];
        $catalogItemStringAttributes = [];
        $catalogItemBooleanAttributes = [];
        $catalogItemSelectAttributes = [];
        $collections = [];

        $updatedCatalogItemIds = [];
        $existingCatalogItemIds = (new Query())
            ->select('catalog_item_id')
            ->from('catalog_item_category')
            ->where(['catalog_category_id' => $this->category_id])
            ->column();

        foreach ($items as $item) {
            $attributes = [];
            if (!empty($item['attributes'])) {
                $attributes = $item['attributes'];
                unset($item['attributes']);
            }


            if (empty( $item['brand_id']) || empty($item['collection_id']) || empty($item['title'])){
                continue;
            }
            $collections[] = $item['collection_id'];

            // defaults
            $item = ArrayHelper::merge(['is_home' => true, 'is_business' => true], $item);
            $model = CatalogItem::find()->where([
                'brand_id'      => $item['brand_id'],
                'collection_id' => $item['collection_id'],
                'title'         => $item['title'],
                'id'            => $existingCatalogItemIds
            ])->one();

            $new = false;
            if (!$model && $this->import_items) {
                $model = new CatalogItem($item);
                $new = true;
                if ($model->validate()) {
                    $this->importedItemsCount++;
                }
            }

            if ($model->load($item) && $model->validate()) {
                if ($new) {
                    $this->importedItemsCount++;
                } else {
                    $this->updatedItemsCount++;
                }
            }

            if (!$model->is_new) {
                $model->description=ArrayHelper::getValue($item,'description');
            }

            if ($model && $model->save(false)) {
                $itemIds[] = $id = $model->id;
                if (!$new) {
                    $updatedCatalogItemIds[] = $model->id;
                }
                unset($model);
                $catalogItemCategory[] = [$id, $this->category_id];

                if (!empty($attributes)) {
                    foreach ($attributes as $attribute) {
                        // do not parse empty values
                        if (empty($attribute['value'])) continue;

                        if ($attribute['type'] === Attribute::TYPE_STRING || $attribute['type'] === Attribute::TYPE_NUMBER) {
                            $catalogItemStringAttributes[] = [$attribute['id'], $id, $attribute['value']];
                        }
                        if ($attribute['type'] === Attribute::TYPE_BOOL) {
                            $value = $attribute['value'] === 'да' ? true : false;
                            $catalogItemBooleanAttributes[] = [$attribute['id'], $id, $value];
                        }
                        if ($attribute['type'] === Attribute::TYPE_SELECT) {
                            $valueModel = AttributeValue::findOne(['ext_key' => $attribute['value']]);
                            if ($valueModel) {
                                $catalogItemSelectAttributes[] = [$attribute['id'], $id, $valueModel->id];
                            } elseif (!$valueModel && $this->import_attribute_values) {
                                $valueModel = new AttributeValue([
                                    'attribute_id' => $attribute['id'],
                                    'ext_key' => $attribute['value'],
                                    'title_ru' => $attribute['value']
                                ]);
                                if ($valueModel->save()) {
                                    $this->importedAttributeValuesCount++;
                                }
                            }
                        }
                    }
                }
            }
        }

        // update category and attribute links
        \Yii::$app->db->createCommand()->delete('catalog_item_category', 'catalog_item_id IN (' .implode(',', $itemIds). ')')->execute();
        \Yii::$app->db->createCommand()->delete('catalog_item_attribute', 'catalog_item_id IN (' .implode(',', $itemIds). ')')->execute();

        \Yii::$app->db->createCommand()->batchInsert('catalog_item_category', [
            'catalog_item_id',
            'catalog_category_id',
        ], $catalogItemCategory)->execute();

        \Yii::$app->db->createCommand()->batchInsert('catalog_item_attribute', [
            'attribute_id',
            'catalog_item_id',
            'string_value_ru',
        ], $catalogItemStringAttributes)->execute();

        \Yii::$app->db->createCommand()->batchInsert('catalog_item_attribute', [
            'attribute_id',
            'catalog_item_id',
            'bool_value',
        ], $catalogItemBooleanAttributes)->execute();

        \Yii::$app->db->createCommand()->batchInsert('catalog_item_attribute', [
            'attribute_id',
            'catalog_item_id',
            'attribute_value_id',
        ], $catalogItemSelectAttributes)->execute();

        if ($this->delete_not_updated) {
            $notUpdated = array_diff($existingCatalogItemIds, $updatedCatalogItemIds);
            if (!empty($notUpdated)) {
                \Yii::$app->db->createCommand()->delete('catalog_item_category', 'catalog_item_id IN (' .implode(',', $notUpdated). ')')->execute();
                \Yii::$app->db->createCommand()->delete('catalog_item_attribute', 'catalog_item_id IN (' .implode(',', $notUpdated). ')')->execute();

                $this->deletedItemsCount = CatalogItem::deleteAll(['id' => $notUpdated]);
            }
        }

        // delete not found collections
        \Yii::$app->db->createCommand()->delete('collection', 'id NOT IN('.implode(',', array_unique($collections)).')');
    }
}