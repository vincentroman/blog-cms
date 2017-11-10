<?php
// Default Time Zone
date_default_timezone_set('America/Los_Angeles');

// DB Connection
$config = require 'config/db_config.php';
try{
    $conn = new PDO(
                $config['connection'].';dbname='.$config['name'],
                $config['username'], 
                $config['password'], 
                $config['options']
            );
}catch(PDOException $e){
    die($e->getMessage());
}