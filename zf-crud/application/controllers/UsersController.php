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
     * Apenas chama a action 'list'
     *
     * @return void
     */
    public function indexAction()
    {
        $this->_forward('list');
    }
 
    /**
     * Exibe uma lista com todos os usuários registrados
     *
     * @return void
     */
    public function listAction()
    {
        $this->view->users = $this->_model->fetchAll();
    }
 
    /**
     * Exibe o form para cadastro de usuário.
     *
     * Registra um novo usuário quando a requisição for POST
     * Caso o nome ou o email informado não forem únicos na tabela, passaremos
     * uma mensagem de erro para a view e não registramos este usuário.
     *
     * @return boolean|void
     */
    public function createAction()
    {
        $form = new Application_Form_User();
        $form->setAction('/users/create');

        if ( $this->_request->isPost() )
        {
            $data = array(
                'name'  => $this->_request->getPost('name'),
                'email' => $this->_request->getPost('email')
            );

            if ( $form->isValid($data) )
            {
                $this->_model->insert($data);
                $this->view->message = "Usu&aacute;rio cadastrado com sucesso.";
            }
        }

        $this->view->form = $form;
    }
 
    /**
     * Exibe o form para edição de usuário.
     *
     * Exibe o form para editar o usuário a partir do ID passado pela URL
     * Se o usuário não existir é exibo uma mensagem de erro e não apresentamos
     * o form.
     *
     * @return void|false
     */
    public function editAction()
    {
        $id      = (int) $this->_getParam('id');
        $result  = $this->_model->find($id);
        $data    = $result->current();

        if ( null === $data )
        {
            $this->view->message = "Usu&aacute;rio n&atilde;o encontrado!";
            return false;
        }

        $form = new Application_Form_User();
        $form->setAsEditForm($data);

        if ( $this->_request->isPost() )
        {
            $data = array(
                'name'  => $this->_request->getPost('name'),
                'email' => $this->_request->getPost('email')
            );

            if ( $form->isValid($data) )
            {
                $this->_model->update($data, "id = $id");
                $this->_redirect('/users');
            }
        }

        $this->view->form = $form; 
    }
 
    /**
     * Deleta um registro e redireciona para 'users/list'
     * Caso não seja informado nenhum ID pela url,
     * o usuário será redirecionado para 'users'
     *
     * @return void
     */
    public function deleteAction()
    {
        // verificamos se realmente foi informado algum ID
        if ( $this->_hasParam('id') == false )
        {
            $this->_redirect('users');
        }
 
        $id = (int) $this->_getParam('id');
        $where = $this->_model->getAdapter()->quoteInto('id = ?', $id);
        $this->_model->delete($where);
        $this->_redirect('users/list');
    } 
}
