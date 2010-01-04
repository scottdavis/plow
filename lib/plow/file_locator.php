<?php
/**
	* This file handles the file system grunt work of plow locating the tasks and plowfile
	*/
class PlowFileLocator {
	static $plow_file_names = array('plowfile', 'Plowfile', 'Plowfile.php', 'plowfile.php', '.plowfile');
	static $task_extensions = array('plow', 'task');
	static $plow_file = '';
	/**
		* Find the plow file for this app 
		* @param string $cwd
		*/
	public static function find_plow_file($cwd) {
		$path_parts = explode(DIRECTORY_SEPARATOR, $cwd);
		while (!empty($path_parts)) {
			foreach(static::$plow_file_names as $type) {
		  	$path = implode(DIRECTORY_SEPARATOR, array_merge($path_parts, array($type)));
		  	if (file_exists($path)) {
					return static::$plow_file = $path;
		  	}
		 	}
			array_pop($path_parts);
		}
		throw new Exception('No Plowfile found');
	}
		
	/**
		* Find the tasks for this app 
		* @param string $cwd
		*/
	public static function find_all_tasks($cwd) {
		$regex = '/\.(' . implode("|" , static::$task_extensions) . ')$/';
		$plow_file = static::find_plow_file($cwd);
		$dir = realpath(dirname($plow_file));
		$task_files = array($plow_file);
		foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)) as $file) {
			if(preg_match($regex , $file)) {
				$task_files[]= (string) $file;
			}
		}
		return $task_files;
	}
	/**
		* Get the task names for this app 
		* @param string $cwd
		*/
	public static function get_task_names($cwd) {
		$files = static::find_all_tasks($cwd);
		$matches = array();
		$out = array();
		foreach($files as $file) {
			$data = file($file);
			foreach($data as $line) {
				if(preg_match('/[c|C]lass\s+([a-zA-z0-9]+)\s+[i|I]mplements\s+PlowTask/', $line, $matches)) {
					$out[] = $matches[1];
				}
			}
			unset($data);
		}
		return $out;
	}

}