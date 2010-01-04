#Plow is a command line tool for chaining dependent tasks

1. `plow::help` - displays this file
2. `plow::version` - displays plow version number
3. `plow::create::task` - makes a new task template
4. `plow::init` - creates a plowfile marking the scope of the app
5. `plow::show::all` - shows all tasks in the current scope


##A task implements as PlowTask interface

	interface PlowTask {
		public function run($args);
		public function name();
		public function dependencies();
	}
	
##Examples
see: [Pearfarms tasks](http://github.com/jetviper21/pearfarm_channel_server/tree/master/tasks/)