<?php

namespace Apis\ApiList\Tests;

use \Apis\ApiList\ApiLister;
use \Apis\Api;

class DocCommentTest extends \PHPUnit_Framework_TestCase {

  function testSimple() {
    $lister = new ApiLister();
    $api = $lister->processAPI(new SimpleTestApi());

    $this->assertEquals("/api/v1/simple", $api['endpoint']);
    $this->assertEquals("A simple test API.", $api['title']);
    $this->assertEquals("This is an extended description.", $api['description']);
  }

  function testAdvanced() {
    $lister = new ApiLister();
    $api = $lister->processAPI(new AdvancedTestApi());

    $this->assertEquals("/api/v1/:currency", $api['endpoint']);
    $this->assertEquals("An advanced test API.", $api['title']);
    $this->assertEquals("This is an extended description.\nIt spans multiple lines.", $api['description']);
    $this->assertEquals(array('currency' => "the currency to use"),
        $api['params']);
  }

}
