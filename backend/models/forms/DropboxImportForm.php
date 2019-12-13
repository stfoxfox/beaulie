<?php

namespace backend\models\forms;

use common\models\CatalogItem;
use common\models\Collection;
use common\models\File;
use common\components\MyExtensions\MyDropbox;
use common\components\MyExtensions\MyFileSystem;
use yii\base\Model;

class DropboxImportForm extends Model
{
    protected $_dropbox;

    public $api_key;
    public $api_secret;
    public $access_token;

    public $allowedExtensions = ['jpg', 'jpeg', 'png'];
    public $maxImageSize = 2048 * 1024; // 2Mb
    public $mainFolderName = 'main';
    public $galleryFolderName = 'gallery';

    public function rules()
    {
        return [
            [['api_key', 'api_secret', 'access_token'], 'required'],
        ];
    }

    /**
     * @param $files
     * @param $catalogItem CatalogItem
     */
    protected function saveMain($files, $catalogItem)
    {
        $realFileName = $files[0]->getName();
        $ext = pathinfo($realFileName, PATHINFO_EXTENSION);
        $fileName = uniqid(microtime(true)) . "_" . md5($realFileName) . "." . $ext;
        if (!in_array($ext, $this->allowedExtensions))
            return ;

        $fileData = $files[0]->getData();
        if ($fileData['.tag'] !== 'file')
            return ;

        if ($fileData['size'] > $this->maxImageSize)
            return ;

        $dropboxFile = $this->_dropbox->download($files[0]->getPathLower());
        $contents = $dropboxFile->getContents();
        $file = new File();
        $file->file_name = $fileName;
        $moved = file_put_contents(MyFileSystem::makeDirs($file->uploadTo('catalog_item', 'file_name')), $contents);
        if ($moved && $file->save()) {
            if ($catalogItem->file) {
                $catalogItem->file->delete();
            }

            $catalogItem->file_id = $file->id;
            $catalogItem->update(false, ['file_id']);
        }
    }

    /**
     * @param $files
     * @param $catalogItem CatalogItem
     */
    public function saveGallery($files, $catalogItem)
    {
        if (!empty($files)) {
            $catalogItem->unlinkAll('files', true);

            foreach ($files as $galleryFile) {
                $galleryFileData = $galleryFile->getData();
                if ($galleryFileData['.tag'] !== 'file')
                    continue;

                if ($galleryFileData['size'] > $this->maxImageSize)
                    continue;

                $dropboxGalleryFile = $this->_dropbox->download($galleryFile->getPathLower());
                $realFileName = $galleryFile->getName();
                $ext = pathinfo($realFileName, PATHINFO_EXTENSION);

                if (!in_array($ext, $this->allowedExtensions))
                    continue;

                $fileName = uniqid(microtime(true)) . "_" . md5($realFileName) . "." . $ext;
                $file = new File();
                $file->file_name = $fileName;
                $moved = file_put_contents(MyFileSystem::makeDirs($file->uploadTo('catalog_item', 'file_name')), $dropboxGalleryFile->getContents());
                if ($moved && $file->save()) {
                    $catalogItem->link('files', $file);
                }
            }
        }
    }

    /**
     * @return bool
     */
    public function import()
    {
        if (!$this->validate())
            return false;

        $this->_dropbox = new MyDropbox([
            'apiKey' => $this->api_key,
            'apiSecret' => $this->api_secret,
            'accessToken' => $this->access_token
        ]);

        $collectionFolders = $this->_dropbox->listFolder('/');
        foreach ($collectionFolders as $collectionFolder) {
            $data = $collectionFolder->getData();
            if ($data['.tag'] === 'folder') {
                // collection
                $collectionTitle = mb_strtolower($collectionFolder->getName());
                $collection = Collection::find()->where('LOWER(title_ru) = :title', [':title' => $collectionTitle])->one();

                if ($collection) {
                    $catalogItemFolders = $this->_dropbox->listFolder($collectionFolder->getPathLower());

                    foreach ($catalogItemFolders as $catalogItemFolder) {
                        $subData = $catalogItemFolder->getData();
                        if ($subData['.tag'] === 'folder') {
                            $title = str_replace(' ', '', mb_strtolower($catalogItemFolder->getName()));
                            if ($title) {
                                $catalogItem = CatalogItem::find()->where('REPLACE(LOWER(title), \' \', \'\') = :title AND collection_id = :collection_id', [
                                    ':collection_id' => $collection->id,
                                    ':title' => $title
                                ])->one();

                                if ($catalogItem) {

                                    $filesFolders = $this->_dropbox->listFolder($catalogItemFolder->getPathLower());
                                    foreach ($filesFolders as $filesFolder) {
                                        if ($filesFolder->getName() === $this->mainFolderName) {
                                            $this->saveMain($this->_dropbox->listFolder($filesFolder->getPathLower()), $catalogItem);
                                        }
                                        if ($filesFolder->getName() === $this->galleryFolderName) {
                                            $this->saveGallery($this->_dropbox->listFolder($filesFolder->getPathLower()), $catalogItem);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

            }
        }
    }
}