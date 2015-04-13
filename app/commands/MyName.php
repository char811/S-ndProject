<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/*
 * class for create admin with artisan
 */

class MyName extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'user:generate';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate a new user.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $user=new User;
        $user->username=$this->argument('username');
        $user->password=Hash::make($this->option('password'));
        $user->save();

        $this->info('User ' . $user->username . ' has been generated!');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('username', InputArgument::REQUIRED, 'The user\'s username'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('password', null, InputOption::VALUE_OPTIONAL, 'The user\'s password', 'password'),
		);
	}

}
