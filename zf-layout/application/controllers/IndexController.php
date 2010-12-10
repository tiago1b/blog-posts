<?php
/* application/controllers/IndexController.php */

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function createAction()
    {
        // action body
    }

    public function editAction()
    {
        // disable layouts for this action:
        $this->_helper->layout->disableLayout();
    }


}
