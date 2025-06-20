<?php

namespace App\Config;

use PDO;

class Database
{

    public static function getConnection()
    {
        $user = 'root';
        $pass = '';

        $dbh = new PDO('mysql:host=localhost;dbname=api_php', $user, $pass);

        return $dbh;
    }
}
