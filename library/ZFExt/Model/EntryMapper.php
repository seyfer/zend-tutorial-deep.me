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

    public function save(ZFExt_Model_Entry $entry)
    {
        $data              = $entry->toArray();
        $data['author_id'] = $entry->author->id;
        unset($data['author']);

//        Zend_Debug::dump($data);

        if (!$entry->id) {
            $entry->id = $this->_getGateway()->insert($data);
        }
        else {

            $where = $this->_getGateway()
                    ->getAdapter()
                    ->quoteInto('id = ?', $entry->id);

            $this->_getGateway()->update($data, $where);
        }
    }

}
