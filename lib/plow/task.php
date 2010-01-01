<?php
/**
	* Default interface for plowtasks
	*/
interface PlowTask {
	public function run($args);
	public function name();
	public function dependencies();
}