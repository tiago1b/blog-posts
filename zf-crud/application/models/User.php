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
     * Primary key field
     *
     * @var string
     */
    protected $_primary = 'id';

    /**
     * Table columns
     *
     * @access protected
     * @var    array
     */
    protected $_cols = array(
        'id',
        'name',
        'email'
    );

    /**
     * Is unique name?
     *
     * Check if $name is unique name in database
     *
     * @param  string $name
     * @return boolean
     */
    public function isUniqueName($name)
    {
        $select = $this->select();
        $select->from($this->_name, 'COUNT(*) AS num')
               ->where('name = ?', $name);
        
        return ($this->fetchRow($select)->num == 0) ? true : false;
    }

    /**
     * Is unique email?
     *
     * Check if $email is unique email in database
     *
     * @param  string $name
     * @return boolean
     */
    public function isUniqueEmail($email)
    {
        $select = $this->select();
        $select->from($this->_name, 'COUNT(*) AS num')
               ->where('email = ?', $email);
        
        return ($this->fetchRow($select)->num == 0) ? true : false;
    }

}

