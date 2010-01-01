<?php
require_once('PHPUnit/Framework.php');
require_once(__DIR__ . '/../lib/plow/file_locator.php');
class FileLocatorTest extends PHPUnit_Framework_TestCase {
	
	public function setUp() {
		$this->plow_path = __DIR__ . '/plow_test_area';
		$this->plow_file = $this->plow_path . '/Plowfile.php';
		$this->test_path = $this->plow_path . '/2/1/2/3';
	}
	
	public function testFindPlowFile() {
		$file = PlowFileLocator::find_plow_file($this->test_path);
		$this->assertEquals($file, $this->plow_file);
	}
	
	public function testFindsTasks() {
		$files = PlowFileLocator::find_all_tasks($this->plow_path);
		$match = array("Plowfile.php", "test.plow", "test2.plow", "test3.task");
		$this->assertEquals($match, array_map(function($t){return basename($t);}, $files));
		
	}
	
	public function testFindsTaskNames() {
		$names = PlowFileLocator::get_task_names($this->plow_path);
		$tasks = array("Test", "Test2", "Test2Other", "Test3");
		$this->assertEquals($tasks, $names);
	}
	
}