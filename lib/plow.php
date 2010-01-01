<?php
require_once(__DIR__ . '/plow/file_locator.php');
require_once(__DIR__ . '/plow/task.php');

/**
	* This class is the work horse of plow
	* loads all the task files and runs the called task
	*/
class Plow {
	
	var $path;
	var $classes = array();
	var $args = array();
	var $dependency_map = array();
	var $name_map = array();
	
	/**
		* @param string $path - getcwd()
		* @param array $args = $argv
		*/
	public function __construct($path, $args = array()) {
		$this->path = $path;
		$this->args = $args;
		$this->load_classes();
		$this->map_commands_class();
		$this->setup_dependancies();
	}
	/**
		* Runs the task stack
		*/
	public function run() {
		$task = $this->args[0];
		$this->run_task($task);
	}
	/**
		* Loads each of the plow files and instantiates the class
		*/
	private function load_classes() {
		foreach(PlowFileLocator::find_all_tasks($this->path) as $file) {
			require_once($file);
		}
		foreach(PlowFileLocator::get_task_names($this->path) as $task) {
			$this->classes[$task] = new $task; 
		}
	}
	/**
		* Creates a dependency map for each plow task
		*/
	private function setup_dependancies() {
		foreach($this->classes as $name => $class) {
			$this->dependency_map[$name] = $class->dependencies();
		}
	}
	/**
		* Creates a command to class map for each plow task
		*/	
	private function map_commands_class() {
		foreach($this->classes as $name => $class) {
			$this->name_map[$name] = $class->name();
		}
	}
	/**
	 * Runs a plow task
	 */
	private function run_task($task) {
		$class_name = array_search($task, $this->name_map);
		$class = $this->classes[$class_name];
		foreach($this->dependency_map[$class_name] as $dependency) {
			$this->run_task($dependency);
		}
		$class->run($this->args);
	}
	
}