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

}
