<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

require 'PHPUnit' . DIRECTORY_SEPARATOR . 'Framework' .
DIRECTORY_SEPARATOR . 'TestCase' ;

class FixtureTestCase extends PHPUnit_Extensions_Database_TestCase {

    public $fixtures = array(
        'posts',
        'postmeta',
        'options'
    );

}
