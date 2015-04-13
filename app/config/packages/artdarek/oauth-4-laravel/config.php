<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
    //'default_scope' => 'basic',
	'consumers' => array(

        'Google' => array(
            'client_id'     => '379386202144-old307dubrdrun2jqu4n8smqqdeshmer.apps.googleusercontent.com',
            'client_secret' => 'BzZBG7Azw7vu9baiJlvE9F0u',
            'redirect_uri'  => 'http://habragrubber.com/oauth2callback',
            'response_type' => 'code',
            'scope'         => array('userinfo_email', 'userinfo_profile'),
        ),

    )

);