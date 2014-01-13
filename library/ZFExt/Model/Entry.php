<?php

class ZFExt_Model_Entry extends ZFExt_Model_Entity {

    protected $_data = array(
        'id'             => null,
        'title'          => '',
        'content'        => '',
        'published_date' => '',
        'author'         => null
    );

    public function __set($name, $value)
    {
        if ($name == 'author' && !$value instanceof ZFExt_Model_Author) {
            throw new ZFExt_Model_Exception('Author can only be set using' .
            ' an instance of ZFExt_Model_Author');
        }

        parent::__set($name, $value);
    }

}
