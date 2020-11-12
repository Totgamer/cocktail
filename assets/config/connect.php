<?php

include('_variables.php');

    $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

    if(!$conn or mysqli_connect_errno()){
        echo mysqli_error($conn);
    } else{
        $conn->set_charset("utf8");
        $conn->query("SET lc_time_names = 'nl_NL';");
    }
    
?>