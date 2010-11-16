<?php
/* application/controllers/UsersController.php */

class UsersController extends Zend_Controller_Action
{
    /**
     * User model
     *
     * @access private
     * @var    User
     */
    private $_model;

    /**
     * Initialize object
     *
     * Called from {@link __construct()} as final step of object instantiation.
     *
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->_model = new User();
    }

    /**
     * Call list action
     *
     * @return void
     */
    public function indexAction()
    {
        $this->_forward('list');
    }

    /**
     * List all users
     *
     * @return void
     */
    public function listAction()
    {
        $this->view->users = $this->_model->fetchAll();
    }

    /**
     * Create new user
     *
     * Create new user in POST request
     * Show error message if the name or email is not unique in database
     * and return false
     *
     * @return boolean|void
     */
    public function createAction()
    {
        if ( $this->_request->isPost() )
        {
            $data = array(
                'name'  => $this->_request->getPost('name'),
                'email' => $this->_request->getPost('email')
            );

            if ( ! $this->_model->isUniqueName($data['name']) )
            {
                $this->view->message = sprintf('J&aacute; exite um usu&aacute;rio 
                    cadastrado com o nome "%s"', $data['name']);

                return false;
            }

            if ( ! $this->_model->isUniqueEmail($data['email']) )
            {
                $this->view->message = sprintf('J&aacute; exite um usu&aacute;rio 
                    cadastrado com o email "%s"', $data['email']);

                return false;
            }

            $this->_model->insert($data);
            $this->view->message = "Usu&aacute;rio cadastrado com sucesso.";
        }
    }

    public function editAction()
    {
        // ...
    }

    private function _update()
    {
        // ...
    }


}
