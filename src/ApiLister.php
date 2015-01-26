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

      if (trim($line)) {
        if ($previous) {
          $result[] = $previous;
          $previous = "";
        }
        $previous = trim($previous . " " . $line);
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
    if (count($lines) > 1) {
      unset($lines[0]);
      return implode("\n", $lines);
    }
    return null;
  }

  function getParams($comment) {
    return $comment;
  }

}
