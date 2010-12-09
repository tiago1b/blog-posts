<?php
/* application/forms/User.php */

class Application_Form_User extends Zend_Form
{

    /**
     * Initialize form (used by extending classes)
     *
     * @return void
     */
    public function init()
    {
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Nome')
             ->setAllowEmpty(false)
             ->setRequired(true)
             ->addValidator('Db_NoRecordExists', false, 
                 array(
                     'table'   => 'users',
                     'field'   => 'name'
                 )
             );

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')
              ->setAllowEmpty(false)
              ->setRequired(true)
              ->addValidators(array(
                  array('EmailAddress'),
                  array('Db_NoRecordExists', false, array(
                      'table' => 'users',
                      'field' => 'email'
                  ))
              ));

        $submit = new Zend_Form_Element_Submit('save');
        $submit->setLabel('Salvar');

        $this->addElements(array($name, $email, $submit));
    }

    /**
     * Seta o form como de edição de registro
     *
     * A diferença entre o form de cadastro e edição é que o no form de edição 
     * não se deve comparar o ID do usuário na hora de procurar por um nome 
     * ou email existentes na base de dados.
     * Por isso, adicionamos a option 'exclude' do validator 
     * Zend_Validate_Db_NoRecordExists passando o campo ID e o valor do usuário
     * que está sendo editado para ser utilizado na clausua where da query,
     * buscando apenas registros cujo id seja diferente do id do usuário
     *
     * @param  Zend_Db_Table_Row     $row
     * @return Application_Form_User
     */
    public function setAsEditForm(Zend_Db_Table_Row $row)
    {
        $this->populate($row->toArray());
        $this->setAction(sprintf('/users/edit/id/%d', $row->id));

        $this->getElement('name')
             ->getValidator('Db_NoRecordExists')
             ->setExclude(array(
                 'field' => 'id',
                 'value' => $row->id
             ));

        $this->getElement('email')
             ->getValidator('Db_NoRecordExists')
             ->setExclude(array(
                 'field' => 'id',
                 'value' => $row->id
             ));

        return $this;
    }
}
