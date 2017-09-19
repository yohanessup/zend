<?php
/**
 * Created by PhpStorm.
 * User: YohanesSuprapto
 * Date: 9/5/2017
 * Time: 8:57 AM
 */

namespace Application;
use Zend\Db\Adapter;

class Connection
{
    public static function getAdapterConnection()
    {
        $adapterConnection = new Adapter\Adapter(array(
            'driver' => 'Mysqli',
            'host' => 'localhost',
            'database' => 'employee',
            'username' => 'root',
            'password' => ''
        ));

        return $adapterConnection;
    }
}