<?php

namespace common\components\MyExtensions;

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use yii\base\Component;

class MyDropbox extends Component
{
    protected $_app;
    protected $_dropbox;

    public $apiKey;
    public $apiSecret;
    public $accessToken;


    public function init()
    {
        $this->_app = new DropboxApp($this->apiKey, $this->apiSecret, $this->accessToken);
        $this->_dropbox = new Dropbox($this->_app);
    }

    public function getMetadata($fileName)
    {
        return $this->_dropbox->getMetadata($fileName);
    }

    public function listFolder($folder)
    {
        $listFolderContents = $this->_dropbox->listFolder($folder);
        return $listFolderContents->getItems()->all();
    }

    public function download($fileName)
    {
        return $this->_dropbox->download($fileName);
    }
}