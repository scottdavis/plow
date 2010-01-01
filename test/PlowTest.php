<?php
require_once('PHPUnit/Framework.php');
require_once(__DIR__ . '/../lib/plow.php');
class PlowTest extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$this->plow_path = __DIR__ . '/plow_test_area';
	}


	public function testPlowLoadsRight() {
		$plow = new Plow($this->plow_path);
		$this->assertEquals(4, count($plow->dependency_map));
		$this->assertEquals(4, count($plow->name_map));
		$this->assertEquals($plow->dependency_map['Test2Other'][0], "Test2")
	}
	
}