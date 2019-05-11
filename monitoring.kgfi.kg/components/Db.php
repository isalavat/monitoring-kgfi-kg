<?php

class Db {
    public static function getConnection(){
        $db_config = include (ROOT."/config/db_config.php");
        $dsn = "mysql:host={$db_config['host']}; dbname={$db_config['dbname']}"; 
        $db = new PDO($dsn, $db_config['user'] , $db_config['password']);
        $db->exec('set names utf8');
        return $db;
    }
}
