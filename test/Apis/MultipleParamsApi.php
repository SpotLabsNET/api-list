<?php

namespace Apis\ApiList\Tests\Apis;

use \Apis\Api;

/**
 * An advanced
 * test API.
 *
 * This is an extended description.
 *
 * It spans multiple lines.
 *
 * @param currency   the currency to use
 * @param foo another parameter
 * @param bar another parameter
 *      across multiple lines
 */
class MultipleParamsApi extends Api {

  function getJSON($arguments) {
    return array();
  }

  function getEndpoint() {
    return "/api/v2/:currency";
  }

}
