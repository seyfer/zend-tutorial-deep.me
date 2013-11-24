<?php

/**
 * Description of IndexController
 *
 * @author seyfer
 */
class IndexController extends Zend_Controller_Action {

    public function init()
    {

    }

    public function indexAction()
    {
        echo 11;
        $this->view->title = 'Hello World!';
    }

}
