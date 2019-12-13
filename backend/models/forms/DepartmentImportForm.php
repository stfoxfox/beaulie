<?php

namespace backend\models\forms;

use common\models\CatalogCategory;
use common\models\Department;
use common\models\Region;
use common\models\WorkingDays;
use common\models\WorkingHours;
use yii\base\Model;
use yii\web\UploadedFile;
use PHPExcel_Cell;

class DepartmentImportForm extends Model
{
    public $country_id;
    public $file;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['country_id'], 'required'],
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

                $map = $this->parseDepartments($headerMap, $sheetData);
                $this->saveDepartmentsMap($map);
            }
        }
    }

    protected function parseHeader($sheetData)
    {
        $map = [];
        $highestCol = $sheetData->getHighestColumn();

        $rowData = $sheetData->rangeToArray('A2:' . $highestCol . '2', null, true, false);

        foreach ($rowData[0] as $index => $colName) {
            if (!empty($colName)) {
                $map[$index] = trim($colName);
            }
        }

        return $map;
    }

    protected function parseDepartments($map, $sheetData)
    {
        $highestRow = $sheetData->getHighestRow();
        $highestCol = $sheetData->getHighestColumn();

        $items = [];
        for ($row = 4; $row <= $highestRow; $row++) {
            $rowData  = $sheetData->rangeToArray('A' . $row . ':' . $highestCol . $row, null, true, false);
            $itemData = $rowData[0];

            $items[$row]['title'] = '';

            foreach ($itemData as $key => $value) {
                if (!isset($map[$key])) continue;

                if ($map[$key] === 'Название магазина') {
                    $items[$row]['title'] = $value;
                } elseif (in_array($map[$key], ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'])) { // collection
                    $items[$row]['working_days'][] = $value;
                } elseif ($map[$key] === 'Адрес') {
                    $items[$row]['address'] = $value;
                } elseif ($map[$key] === 'Телефон') {
                    $items[$row]['phone'] = $value;
                } elseif ($map[$key] === 'Сайт') {
                    $items[$row]['site_url'] = $value;
                } elseif ($map[$key] === 'Город') {
                    $items[$row]['city'] = $value;
                } elseif ($map[$key] === 'Координаты'){
                    if(!empty($value)){
                        $coords = explode(',', $value);
                        $items[$row]['lat'] = $coords[0];
                        $items[$row]['lng'] = $coords[1];
                    }
                } else{
                    $items[$row]['category'][$map[$key]] = $value === "да";
                }
            }
        }

        return $items;
    }

    protected function saveDepartmentsMap($map)
    {
        foreach ($map as $item) {
            $workingDays = false;

            if (isset($item['working_days'])) {
                $workingDays = $item['working_days'];
                unset($item['working_days']);
            }

            if (isset($item['city'])) {
                $city = mb_strtolower($item['city']);
                $cityModel = Region::find()->where('LOWER(title) = :title AND country_id = :country_id', [
                    ':title' => $city,
                    ':country_id' => $this->country_id
                ])->one();

                if (!$cityModel) {
                    $cityModel = new Region([
                        'title' => mb_convert_case($city, MB_CASE_TITLE, 'UTF8'),
                        'country_id' => $this->country_id
                    ]);
                    $cityModel->save();
                }
                $item['region_id'] = $cityModel->id;
                unset($item['city']);
            }

            $category = [];
            if(isset($item['category'])){
                $category = $item['category'];
                unset($item['category']);
            }

            $department = new Department($item);
            $department->is_active = true;

            if ($department->save() && $workingDays) {
                foreach ($workingDays as $key => $hours) {
                    $weekDay = $key + 1;
                    $workingDay= new WorkingDays();
                    $workingDay->department_id=$department->id;
                    $workingDay->weekday=$weekDay;
                    $workingDay->status=WorkingDays::STATUS_HAS_HOURS;
                    if ($workingDay->save()) {
                        $hoursData = explode(' - ', $hours);
                        if (count($hoursData) !== 2) {
                            $hoursData = explode(' – ', $hours);
                        }

                        if (count($hoursData) === 2) {
                            list($start, $stop) = $hoursData;
                            $workingHours= new WorkingHours();
                            $workingHours->working_day_id= $workingDay->id;
                            $workingHours->open_time=$start;
                            $workingHours->close_time=$stop;
                            $workingHours->save();
                        }
                    }
                }

                foreach($category as $key => $value){
                    if($value){
                        $category = CatalogCategory::findOne(['title_ru' => trim($key)]);
                        if($category){
                            $department->link('catalogCategories', $category);
                        }
                    }

                }
            }
        }
    }
}
