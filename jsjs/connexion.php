<?php
    $dbhost = 'mysql-salimata00.alwaysdata.net';
    $dbname = 'salimata00_jsquizz';
    $dbuser = '341804';
    $dbpswd = '341804dbjsjsdbjsjs';
    try{
        $conn = new PDO('mysql:host='.$dbhost.';dbname='.$dbname,$dbuser,$dbpswd,
        array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
            )
        );
    }catch (PDOException $e){
        die("Une erreur est survenue lors de la connexion à la Base de données !");
    }