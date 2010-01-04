<?php
require_once(__DIR__ . '/plow/file_locator.php');
require_once(__DIR__ . '/plow/task.php');

/**
	* This class is the work horse of plow
	* loads all the task files and runs the called task
	*/
class Plow {
	
	var $global_tasks;
	var $path;
	var $classes = array();
	var $args = array();
	var $dependency_map = array();
	var $name_map = array();
	var $task_locations = array();
	
	
	/**
		* @param string $path - getcwd()
		* @param array $args = $argv
		*/
	public function __construct($path, $args = array()) {
		$this->global_tasks = __DIR__ . '/../tasks';
		$this->path = $path;
		$this->args = $args;
		$this->args[0] = $this;
		$this->add_task_location($this->global_tasks);
		$this->add_task_location($this->path);
		$this->load_classes();
		$this->map_commands_class();
		$this->setup_dependancies();
	}
	
	public function add_task_location($loc) {
		$this->task_locations[] = $loc;
	}
	
	/**
		* Loads all tasks from current structure and other locations set with add_task_location
		*
		*/
	public function find_tasks() {
		$out = array();
		foreach($this->task_locations as $loc) {
 			$out = array_merge($out, PlowFileLocator::find_all_tasks($loc));
		}
		return $out;
	}
	
	public function get_task_names() {
		$out = array();
		foreach($this->task_locations as $loc) {
			$out = array_merge($out, PlowFileLocator::get_task_names($loc));
		}
		return $out;
	}
	/**
		* Runs the task stack
		*/
	public function run() {
		$task = $this->args[1];
		$this->run_task($task);
	}
	/**
		* Loads each of the plow files and instantiates the class
		*/
	private function load_classes() {
		foreach($this->find_tasks() as $file) {
			require_once($file);
		}
		foreach($this->get_task_names() as $task) {
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