<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		$users = array(
			array(
				'username' => 'krit',
				'email'	=> 'krit@krit.com',
                'mobile' => '123456',
				//'password' => Hash::make('krit'),
				'updated_at' => DB::raw('NOW()'),
				'created_at' => DB::raw('NOW()'),
				)
		);

		DB::table('users')->insert($users);
	}

}
