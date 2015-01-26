<?php

use \Apis\ApiList\ApiLister;
use \Apis\Api;

/**
 * A simple test API.
 *
 * This is an extended description.
 */
class SimpleTestApi extends Api {

  function getJSON($arguments) {
    return array();
  }

  function getEndpoint() {
    return "/api/v1/simple";
  }

}

/**
 * An advanced
 * test API.
 *
 * This is an extended description.
 *
 * It spans multiple lines.
 *
 * @param currency   the currency to use
 */
class AdvancedTestApi extends Api {

  function getJSON($arguments) {
    return array();
  }

  function getEndpoint() {
    return "/api/v1/:currency";
  }

}

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
