<?php

/**
 * Description of EntryMapperTest
 *
 * @author seyfer
 */
class ZFExt_Model_EntryMapperTest extends PHPUnit_Framework_TestCase {

    protected $_tableGateway = null;
    protected $_adapter      = null;
    protected $_rowset       = null;
    protected $_mapper       = null;

    public function setup()
    {
        $this->_tableGateway = $this->_getCleanMock('Zend_Db_Table_Abstract');
        $this->_adapter      = $this->_getCleanMock('Zend_Db_Adapter_Abstract');
        $this->_rowset       = $this->_getCleanMock('Zend_Db_Table_Rowset_Abstract');

        $this->_tableGateway->expects($this->any())
                ->method('getAdapter')
                ->will($this->returnValue($this->_adapter));

        $this->_mapper = new ZFExt_Model_EntryMapper($this->_tableGateway);
    }

    /**
     * создает чистую заглушку
     * @param type $className
     * @return type
     */
    protected function _getCleanMock($className)
    {
        $class       = new ReflectionClass($className);
        $methods     = $class->getMethods();
        $stubMethods = array();

        foreach ($methods as $method) {
            if ($method->isPublic() || ($method->isProtected() && $method->isAbstract())) {
                $stubMethods[] = $method->getName();
            }
        }

        $mocked = $this->getMock($className, $stubMethods, array(), $className .
                '_EntryMapperTestMock_' . uniqid(), false);

        return $mocked;
    }

    public function testSavesNewEntryAndSetsEntryIdOnSave()
    {
        $author = new ZFExt_Model_Author(array(
            'id'       => 2,
            'username' => 'joe_bloggs',
            'fullname' => 'Joe Bloggs',
            'email'    => 'joe@example.com',
            'url'      => 'http://www.example.com'
                )
        );

        $entry         = new ZFExt_Model_Entry(array(
            'title'          => 'My Title',
            'content'        => 'My Content',
            'published_date' => '2009-08-17T17:30:00Z',
            'author'         => $author
                )
        );
// set mock expectation on calling Zend_Db_Table::insert()
        $insertionData = array(
            'id'             => NULL,
            'title'          => 'My Title',
            'content'        => 'My Content',
            'published_date' => '2009-08-17T17:30:00Z',
            'author_id'      => 2
        );

        $this->_tableGateway
                ->expects($this->once())
                ->method('insert')
                ->with($this->equalTo($insertionData))
                ->will($this->returnValue(123));

        $this->_mapper->save($entry);
        $this->assertEquals(123, $entry->id);
    }

    public function testUpdatesExistingEntry()
    {
        $author = new ZFExt_Model_Author(array(
            'id'       => 2,
            'username' => 'Joe Bloggs',
            'email'    => 'joe@example.com',
            'url'      => 'http://www.example.com'
        ));

        $entry = new ZFExt_Model_Entry(array(
            'id'             => 1,
            'title'          => 'My Title',
            'content'        => 'My Content',
            'published_date' => '2009-08-17T17:30:00Z',
            'author'         => $author
        ));

        //// set mock expectation on calling Zend_Db_Table::update()
        $updateData = array(
            'id'             => 1,
            'title'          => 'My Title',
            'content'        => 'My Content',
            'published_date' => '2009-08-17T17:30:00Z',
            'author_id'      => 2
        );

// quoteInto() is called to escape parameters from the adapter
        $this->_adapter
                ->expects($this->once())
                ->method('quoteInto')
                ->will($this->returnValue('id = 1'));

        $this->_tableGateway
                ->expects($this->once())
                ->method('update')
                ->with($this->equalTo($updateData), $this->equalTo('id = 1'));

        $this->_mapper->save($entry);
    }

}
