<?php

namespace Apis\ApiList\Tests;

use \Apis\ApiList\ApiListApi;
use \Apis\Api;

class ApiListApiTestApi extends ApiListApi {

  function getAPIs() {
    return array(
      new Apis\SimpleTestApi(),
      new Apis\AdvancedTestApi(),
      new Apis\MultipleParamsApi(),
    );
  }

}

class ApiListApiTest extends \PHPUnit_Framework_TestCase {

  function testApi() {
    $api = new ApiListApiTestApi();
    $json = $api->getJSON(array());

    $this->assertEquals('/api/v1/simple', $json[0]['endpoint']);
    $this->assertEquals('/api/v1/:currency', $json[1]['endpoint']);
    $this->assertEquals('/api/v2/:currency', $json[2]['endpoint']);
  }

}
