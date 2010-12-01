<?php
/* application/models/User.php */

class User extends Zend_Db_Table_Abstract
{
    /**
     * Default table name
     *
     * @access protected
     * @var    string
     */
    protected $_name = 'users';

    /**
     * O nome é único?
     *
     * Verifica se $name é único na base de dados
     * Caso $id seja informado, ele será usado na cláusula where
     * para selecionar os registros diferentes a este $id.
     *
     * @param  string  $name
     * @param  integer $id [Opcional]
     * @return boolean
     */
    public function isUniqueName($name, $id = null)
    {
        $select = $this->select();
        $select->from($this->_name, 'COUNT(*) AS num')
               ->where('name = ?', $name);
 
        if ( $id != null )
        {
            $select->where('id != ?', (int) $id);
        }
 
        return ($this->fetchRow($select)->num == 0) ? true : false;
    }
 
    /**
     * O email é único?
     *
     * Verifica se $email é único na base de dados
     * Caso $id seja informado, ele será usado na cláusula where
     * para selecionar os registros diferentes a este $id.
     *
     * @param  string  $email
     * @param  integer $id [Opcional]
     * @return boolean
     */
    public function isUniqueEmail($email, $id = null)
    {
        $select = $this->select();
        $select->from($this->_name, 'COUNT(*) AS num')
               ->where('email = ?', $email);
 
        if ( $id != null )
        {
            $select->where('id != ?', (int) $id);
        }
 
        return ($this->fetchRow($select)->num == 0) ? true : false;
    }

}

