<?php

/**
 * Description of AllTests
 *
 * @author seyfer
 */
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'ZFExt_Model_AllTests::main');
}

//require_once 'TestHelper.php';
require_once 'ZFExt/Model/EntryTest.php';

class ZFExt_Model_AllTests {

    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('ZFSTDE Blog Suite: Models');
        $suite->addTestSuite('ZFExt_Model_EntryTest');
        return $suite;
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

if (PHPUnit_MAIN_METHOD == 'ZFExt_Model_AllTests::main') {
    ZFExt_Model_AllTests::main();
}

