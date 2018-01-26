<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;


class FixtureTestCase extends PHPUnit_Extensions_Database_TestCase {

    public $fixtures = array(
        'posts',
        'postmeta',
        'options'
    );

}
