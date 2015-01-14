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

class DocCommentTest extends \PHPUnit_Framework_TestCase {

  function testSimple() {
    $lister = new ApiLister();
    $api = $lister->processAPI(new SimpleTestApi());

    $this->assertEquals("/api/v1/simple", $api['endpoint']);
    $this->assertEquals("A simple test API", $api['title']);
  }

}
