<?php

/**
 * Description of EntryMapper
 *
 * @author seyfer
 */
class ZFExt_Model_EntryMapper extends ZFExt_Model_Mapper {

    protected $_tableName         = 'entries';
    protected $_entityClass       = 'ZFExt_Model_Entry';
    protected $_authorMapperClass = 'ZFExt_Model_AuthorMapper';
    protected $_authorMapper      = null;

    public function setAuthorMapper(ZFExt_Model_AuthorMapper $mapper)
    {
        $this->_authorMapper = $mapper;
    }

    public function save(ZFExt_Model_Entry $entry)
    {
        $data              = $entry->toArray();
        $data['author_id'] = $entry->author->id;
        unset($data['author']);

//        Zend_Debug::dump($data);

        if (!$entry->id) {
            $entry->id = $this->_getGateway()->insert($data);
            $this->_setIdentity($entry->id, $entry);
        }
        else {

            $where = $this->_getGateway()
                    ->getAdapter()
                    ->quoteInto('id = ?', $entry->id);

            $this->_getGateway()->update($data, $where);
        }
    }

    public function find($id)
    {
        if ($this->_getIdentity($id)) {
            return $this->_getIdentity($id);
        }

        $result = $this->_getGateway()->find($id)->current();

        $entry = new $this->_entityClass(array(
            'id'             => $result->id,
            'title'          => $result->title,
            'content'        => $result->content,
            'published_date' => $result->published_date,
        ));

        $entry->setReferenceId('author', $result->author_id);
        $this->_setIdentity($id, $entry);

        return $entry;
    }

    public function delete($entry)
    {
        if ($entry instanceof ZFExt_Model_Entry) {
            $where = $this->_getGateway()->getAdapter()->quoteInto("id = ?", $entry->id);
        }
        else {
            $where = $this->_getGateway()->getAdapter()->quoteInto("id = ?", $entry);
        }

        $this->_getGateway()->delete($where);
    }

}
