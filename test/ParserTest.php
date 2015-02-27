<?php

namespace Apis\ApiList\Tests;

use \Apis\ApiList\ApiLister;
use \Apis\Api;

/**
 * Test how lines are parsed.
 */
class ParserTest extends \PHPUnit_Framework_TestCase {

  function testSimpleLines() {
    $lister = new ApiLister();
    $this->assertEquals(array(
      "hello world"
    ), $lister->getLines("/**\n * hello\n* world\n */"));
  }

  function testSimpleTwoLines() {
    $lister = new ApiLister();
    $this->assertEquals(array(
      "hello world",
      "hello world"
    ), $lister->getLines("/**\n * hello\n* world\n *\n * hello world\n */"));
  }

  function testSimpleTwoLinesBlock() {
    $lister = new ApiLister();
    $this->assertEquals(array(
      "hello world",
      "hello world"
    ), $lister->getLines("/**
 * hello
 * world
 *
 * hello world
 */"));
  }

  function testParams() {
    $lister = new ApiLister();
    $this->assertEquals(array(
      "hello world",
      "@param one",
      "@param two",
    ), $lister->getLines("/**
 * hello
 * world
 *
 * @param one
 * @param two
 */"));
  }

  function testParamsMultipleLines() {
    $lister = new ApiLister();
    $this->assertEquals(array(
      "hello world",
      "@param one across multiple lines",
      "@param two across multiple lines",
      "another line"
    ), $lister->getLines("/**
 * hello
 * world
 *
 * @param one across
 *            multiple lines
 * @param two
 *    across multiple
 *    lines
 *
 * another
 * line
 */"));
  }

}
