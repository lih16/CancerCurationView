<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

require 'PHPUnit' . DIRECTORY_SEPARATOR . 'Extensions' .
DIRECTORY_SEPARATOR . 'Database'  . DIRECTORY_SEPARATOR .
'TestCase.php';

class FixtureTestCase extends PHPUnit_Extensions_Database_TestCase {

    public $fixtures = array(
        'posts',
        'postmeta',
        'options'
    );

}
