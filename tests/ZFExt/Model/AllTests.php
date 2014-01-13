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
require_once 'EntryTest.php';
require_once 'AuthorTest.php';

class ZFExt_Model_AllTests {

    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('ZFSTDE Blog Suite: Models');

        $suite->addTestSuite('ZFExt_Model_EntryTest');
        $suite->addTestSuite('ZFExt_Model_AuthorTest');
        $suite->addTestSuite('ZFExt_Model_EntryMapperTest');
        $suite->addTestSuite('ZFExt_Model_AuthorMapperTest');

        return $suite;
    }

}

if (PHPUnit_MAIN_METHOD == 'ZFExt_Model_AllTests::main') {
    ZFExt_Model_AllTests::main();
}

