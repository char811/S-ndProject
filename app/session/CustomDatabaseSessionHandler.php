<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 26.11.14
 * Time: 0:49
 */
namespace App\Session;

use Illuminate\Session\DatabaseSessionHandler;

class CustomDatabaseSessionHandler extends DatabaseSessionHandler {


    public function open($savePath, $sessionName)
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function close()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */

}