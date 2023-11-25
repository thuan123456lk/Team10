<?php
    $serverName = "localhost";
    $connectionOptions = array(
        "Database" => "QUANLYBDS_team_10",
  
        "CharacterSet" => "UTF-8"
    );

    $conn = sqlsrv_connect($serverName, $connectionOptions);

    if($conn === false) {
        die(print_r(sqlsrv_errors(), true));
    }
?>