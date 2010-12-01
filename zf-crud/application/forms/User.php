<?php
/* application/forms/User.php */

class Application_Form_User extends Zend_Form
{

    public function init()
    {
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Nome');

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email');

        $submit = new Zend_Form_Element_Submit('save');
        $submit->setLabel('Salvar');

        $this->addElements(array($name, $email, $submit));
    }
}
