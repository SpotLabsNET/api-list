<?php

namespace Apis\ApiList;

use \Apis\Api;

abstract class ApiListApi extends Api {

  /**
   * This can be controlled e.g. with component-discovery
   *
   * @return a list of all Api instances that we will iterate over
   */
  abstract function getAPIs();

  function getJSON($arguments) {
    $lister = new ApiLister();
    $result = $lister->processAPIs($this->getAPIs());

    $json = array();

    foreach ($result as $api) {
      $json[] = array(
        'endpoint' => $api['endpoint'],
        'title' => $api['title'],
        'description' => $api['description'],
        'params' => $api['params'],
      );
    }

    return $json;
  }

  function getEndpoint() {
    return "/api/v1/simple";
  }


}
