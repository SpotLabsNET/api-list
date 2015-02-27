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

  function getLines($comment) {
    $lines = explode("\n", $comment);
    $result = array();
    $previous = "";
    foreach ($lines as $i => $line) {
      $line = preg_replace("#^\\s*/\\*+\\s*#", "", $line);
      $line = preg_replace("#\\s*\\*/$#", "", $line);
      $line = preg_replace("#^\\s*\\*\\s*#", "", $line);
      $line = preg_replace("#\\s+#", " ", $line);

      if (trim($line)) {
        if (substr(trim($line), 0, 1) == "@") {
          if ($previous) {
            $result[] = $previous;
          }
          $previous = trim($line);
        } else {
          $previous = trim($previous . " " . $line);
        }
      } else {
        if ($previous) {
          $result[] = $previous;
          $previous = "";
        }
      }
    }
    if ($previous) {
      $result[] = $previous;
    }
    return $result;
  }

  function getTitle($comment) {
    $lines = $this->getLines($comment);
    return isset($lines[0]) ? $lines[0] : null;
  }

  function getDescription($comment) {
    $lines = $this->getLines($comment);
    $result = array();
    for ($i = 1; $i < count($lines); $i++) {
      if (substr($lines[$i], 0, 1) !== "@") {
        $result[] = $lines[$i];
      }
    }
    return implode("\n", $result);
  }

  function getParams($comment) {
    $lines = $this->getLines($comment);
    $result = array();
    for ($i = 1; $i < count($lines); $i++) {
      if (substr($lines[$i], 0, strlen("@param")) == "@param") {
        $bits = explode(" ", $lines[$i], 3);
        switch (count($bits)) {
          case 3:
            $result[$bits[1]] = $bits[2];
            break;
          case 2:
            $result[] = $bits[2];
            break;
        }
      }
    }
    return $result;
  }

}
