<?php

/**
 * Description of AuthorMapper
 *
 * @author seyfer
 */
class ZFExt_Model_AuthorMapper {

    protected $_tableGateway = null;
    protected $_tableName    = 'authors';
    protected $_entityClass  = 'ZFExt_Model_Author';

    public function __construct(Zend_Db_Table_Abstract $tableGateway)
    {
        if (is_null($tableGateway)) {
            $this->_tableGateway = new Zend_Db_Table($this->_tableName);
        }
        else {
            $this->_tableGateway = $tableGateway;
        }
    }

    public function save(ZFExt_Model_Author $author)
    {
        $data = $author->toArray();

        if (!$author->id) {
            $author->id = $this->_getGateway()->insert($data);
        }
        else {
            $where = $this->_getGateway()
                    ->getAdapter()
                    ->quoteInto("id = ?", $author->id);

            $this->_getGateway()->update($data, $where);
        }
    }

    /**
     *
     * @return Zend_Db_Table_Abstract
     */
    public function _getGateway()
    {
        return $this->_tableGateway;
    }

    public function find($id)
    {
        $result = $this->_getGateway()->find($id)->current();


        $author = new $this->_entityClass(array(
            "id"       => $result->id,
            "fullname" => $result->fullname,
            "username" => $result->username,
            "email"    => $result->email,
            'url'      => $result->url
        ));

        return $author;
    }

    public function delete($author)
    {
        if ($author instanceof ZFExt_Model_Author) {
            $where = $this->_getGateway()
                    ->getAdapter()
                    ->quoteInto('id = ?', $author->id);
        }
        else {
            $where = $this->_getGateway()
                    ->getAdapter()
                    ->quoteInto('id = ?', $author);
        }

        $this->_getGateway()->delete($where);
    }

}
