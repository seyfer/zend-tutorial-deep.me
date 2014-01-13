<?php

/**
 * Description of EntryMapper
 *
 * @author seyfer
 */
class ZFExt_Model_EntryMapper {

    protected $_tableGateway = null;
    protected $_tableName    = 'entries';

    public function __construct(Zend_Db_Table_Abstract $tableGateway)
    {
        if (is_null($tableGateway)) {
            $this->_tableGateway = new Zend_Db_Table($this->_tableName);
        }
        else {
            $this->_tableGateway = $tableGateway;
        }
    }

    protected function _getGateway()
    {
        return $this->_tableGateway;
    }

}
