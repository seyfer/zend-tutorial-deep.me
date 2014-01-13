<?php

require_once 'ZFExt/Model/Entry.php';

class ZFExt_Model_EntryTest extends PHPUnit_Framework_TestCase {

    public function testSetsAllowedDomainObjectProperty()
    {
        $entry        = new ZFExt_Model_Entry;
        $entry->title = 'My Title';

        $this->assertEquals('My Title', $entry->title);
    }

    public function testConstructorInjectionOfProperties()
    {
        $data = array(
            'title'          => 'My Title',
            'content'        => 'My Content',
            'published_date' => '2009-08-17T17:30:00Z',
            'author'         => new ZFExt_Model_Author
        );

        $entry          = new ZFExt_Model_Entry($data);
        $expected       = $data;
        $expected['id'] = null;
        $this->assertEquals($expected, $entry->toArray());
    }

    public function testCannotSetNewPropertiesUnlessDefinedForDomainObject()
    {
        $entry = new ZFExt_Model_Entry;
        try {
            $entry->notdefined = 1;
            $this->fail('Setting new property not defined in class should' .
                    ' have raised an Exception');
        }
        catch (ZFExt_Model_Exception $e) {

        }
    }

    public function testThrowsExceptionIfAuthorNotAnAuthorEntityObject()
    {
        $entry = new ZFExt_Model_Entry;
        try {
            $entry->author = 1;
            $this->fail('Setting author should have raised an Exception' .
                    ' since value was not an instance of ZFExt_Model_Author');
        }
        catch (ZFExt_Model_Exception $e) {

        }
    }

    public function testReturnsIssetStatusOfProperties()
    {
        $entry        = new ZFExt_Model_Entry;
        $entry->title = 'My Title';
        $this->assertTrue(isset($entry->title));
    }

    public function testCanUnsetAnyProperties()
    {
        $entry        = new ZFExt_Model_Entry;
        $entry->title = 'My Title';
        unset($entry->title);
        $this->assertFalse(isset($entry->title));
    }

}
