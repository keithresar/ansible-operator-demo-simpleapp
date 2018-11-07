<?php

error_reporting(0);

if (gethostbyname("mariadb")!="mariadb")  {
        $dbhost = "mariadb";
        $dbuser = "root";
        $dbpwd = "mypassword";
        $dbname = "mydatabase";

    $connection = new mysqli($dbhost, $dbuser, $dbpwd, $dbname);
    if ($connection->connect_errno)  {
        http_response_code(425);
        exit;
    }
    // DDL blind creation
    $rs = $connection->query("create table if not exists version  ( cur_version int not null, primary key (cur_version))");

    // Get current version
    $rs = $connection->query("select MAX(cur_version) as cur_version from version");
    if (!mysqli_num_rows($rs))  $row['cur_version'] = 0;
    else  $row = $rs->fetch_array(MYSQLI_ASSOC);
    $version = $row['cur_version'];

    $rs->close();
    $connection->close();
}  else  {
    $version = 0;
}


print json_encode(["version" => $version]);


?>
