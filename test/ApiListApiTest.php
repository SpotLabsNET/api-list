<?php

namespace Apis\ApiList\Tests;

use \Apis\ApiList\ApiListApi;
use \Apis\Api;

class ApiListApiTestApi extends ApiListApi {

  function getAPIs() {
    return array(
      new SimpleTestApi(),
      new AdvancedTestApi(),
    );
  }

}

class ApiListApiTest extends \PHPUnit_Framework_TestCase {

  function testApi() {
    $api = new ApiListApiTestApi();
    $json = $api->getJSON(array());

    $this->assertEquals('/api/v1/simple', $json[0]['endpoint']);
    $this->assertEquals('/api/v1/:currency', $json[1]['endpoint']);
  }

}
