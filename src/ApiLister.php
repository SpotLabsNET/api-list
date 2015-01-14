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
      $result[$api->getEndpoint()] = array(
        'endpoint' => $api->getEndpoint(),
        'class' => get_class($api),
      );
    }

    return $result;
  }

}
