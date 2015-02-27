<?php

namespace Apis\ApiList\Tests;

use \Apis\ApiList\ApiLister;
use \Apis\Api;

class DocCommentTest extends \PHPUnit_Framework_TestCase {

  function testSimple() {
    $lister = new ApiLister();
    $api = $lister->processAPI(new Apis\SimpleTestApi());

    $this->assertEquals("/api/v1/simple", $api['endpoint']);
    $this->assertEquals("A simple test API.", $api['title']);
    $this->assertEquals("This is an extended description.", $api['description']);
  }

  function testAdvanced() {
    $lister = new ApiLister();
    $api = $lister->processAPI(new Apis\AdvancedTestApi());

    $this->assertEquals("/api/v1/:currency", $api['endpoint']);
    $this->assertEquals("An advanced test API.", $api['title']);
    $this->assertEquals("This is an extended description.\nIt spans multiple lines.", $api['description']);
    $this->assertEquals(array('currency' => "the currency to use"),
        $api['params']);
  }

  function testMultipleParams() {
    $lister = new ApiLister();
    $api = $lister->processAPI(new Apis\MultipleParamsApi());

    $this->assertEquals("/api/v2/:currency", $api['endpoint']);
    $this->assertEquals("An advanced test API.", $api['title']);
    $this->assertEquals("This is an extended description.\nIt spans multiple lines.", $api['description']);
    $this->assertEquals(array(
        'currency' => "the currency to use",
        'foo' => "another parameter",
        'bar' => "another parameter across multiple lines",
      ),
      $api['params']);
  }

}
