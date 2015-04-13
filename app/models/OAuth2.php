<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 23.01.15
 * Time: 18:30
 */
use Artdarek\OAuth\Facade\OAuth;

class OAuth2My
{
    protected $oauth;

    public function __construct(OAuth $oauth) {
        $this->oauth = $oauth;
    }
}