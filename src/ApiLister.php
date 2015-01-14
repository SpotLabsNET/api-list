<?php

namespace Apis\ApiList;

class ApiLister {

  /**
   * Given a list of {@link Api}s, return all of their
   * documentation at runtime.
   */
  function processAPIs($apis) {
    $result = array();

    foreach ($apis as $api) {
      $result[$api->getEndpoint()] = $this->processAPI($api);
    }

    return $result;
  }

  function processAPI($api) {
    $rc = new \ReflectionClass($api);

    return array(
      'endpoint' => $api->getEndpoint(),
      'class' => get_class($api),
      'title' => $this->getTitle($rc->getDocComment()),
      'description' => $this->getDescription($rc->getDocComment()),
      'params' => $this->getParams($rc->getDocComment()),
      'comment' => $rc->getDocComment(),
    );
  }

}
