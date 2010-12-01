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
 
    /**
     * Exibe o form para edição de usuário.
     *
     * Executa o método '_update' quando a requisição for POST
     * Caso o nome ou o email informado não forem únicos, passaremos
     * uma mensagem de erro para a view e não atualizaremos este usuário.
     *
     * @return void
     */
    public function editAction()
    {
        $user_id = (int) $this->_getParam('id');
        $result  = $this->_model->find($user_id);
        if ( count($result) == 0 )
        {
            $this->view->message = "Usu&aacute;rio n&atilde;o encontrado!";
        }
 
        $this->view->user = $result->current();
 
        if ( $this->getRequest()->isPost() )
        {
            $data = $this->getRequest()->getPost();
 
            if ( ! $this->_model->isUniqueName($data['name'], $data['id']) )
            {
                $this->view->message = sprintf('J&aacute; exite um usu&aacute;rio
                    cadastrado com o nome "%s"', $data['name']);
 
                return false;
            }
 
            if ( ! $this->_model->isUniqueEmail($data['email'], $data['id']) )
            {
                $this->view->message = sprintf('J&aacute; exite um usu&aacute;rio
                    cadastrado com o email "%s"', $data['email']);
 
                return false;
            }
 
            $this->_update($data);
            $this->_redirect('/users');
        }
 
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
 
    /**
     * Executa a atualização do usuário de acordo com os parâmetros
     *
     * @param  array   $data Dados para atualizar
     * @return integer       Numero de linhas atualizadas
     */
    private function _update(array $data)
    {
        $where = $this->_model->getAdapter()->quoteInto('id = ?', (int) $data['id']);
        $data = array(
            'name'  => $data['name'],
            'email' => $data['email']
        );
 
        return $this->_model->update($data, $where);
    }
 
}
