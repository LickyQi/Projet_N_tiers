<?php
    
    /*
     * @author LI Qi
     * mysql_connect is deprecated
     * So I use mysqli_connect to connect PHP and MySql
     */
    
    $databaseHost = '127.0.0.1';
    // localhost and 127.0.0.1 are different here
    // but I don't konw the reason
    $databaseName = 'ntiers';
    $databaseUsername = 'root';
    $databasePassword = 'Liqi8681,';
    
    error_reporting(0);
    // ignore the warning
    
    $mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);
    
    //Select the default character encoding
    mysqli_set_charset($mysqli, 'utf8');
    
    if(mysqli_connect_error())
    {
        die("Connection failed: " . mysqli_connect_error());
    }
    ?>
