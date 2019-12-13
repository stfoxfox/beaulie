<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 20/07/2017
 * Time: 15:56
 */

namespace common\widgets;


class Nav extends \yii\bootstrap\Nav
{
    /**
     * Renders the widget.
     */
    public function run()
    {

        return $this->renderItems();
    }
}