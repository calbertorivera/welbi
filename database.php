<?php

require_once 'db_cred.php';

function db_connect()
{   
    $conn = new PDO('mysql:host='.DB_SERVER.';port='.DB_SERVER_PORT.';dbname='.DB_NAME, DB_USER , DB_PASS);
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $conn ;     
}

function db_queryAll($sql, $conn)
{

    try {
        global $conn;

        //run the query and store the results
        $cmd = $conn->prepare($sql);
    
        //Execute the command
        $cmd -> execute();
        $games = $cmd-> fetchAll();
        return $games;

    } catch (Exception $th) {
        //throw $th;
        //header("Location: error.php");
        echo $th;
   
    }

  
}

function db_disconnect($conn)
{

    if(isset($conn))
    {
        //disconnect
        $conn = null;
    }
}

function db_queryOne($sql, $conn)
{
    try {
        global $conn;

        //run the query and store the results
        $cmd = $conn->prepare($sql);

        //Execute the command
        $cmd -> execute();
        $games = $cmd-> fetch();
        return $games;
    } catch (Exception $th) {
        //throw $th;
        header("Location: error.php");
    }
}



?>