<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 25.08.15
 * Time: 12:47
 */

namespace common\components\controllers;

use Yii;
use yii\web\Controller;

class FrontendController extends Controller {

	public $darkHeader = false;

	public function beforeAction($action)
	{
	    // your custom code here, if you want the code to run before action filters,
	    // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl
		$this->view->params['darkHeader'] = $this->darkHeader;

	    if (!parent::beforeAction($action)) {
	        return false;
	    }

	    // other custom code here

	    return true; // or false to not run the action
	}
}
