<body style="font-size: 3em;">
<?php




echo "Welcome to my stateless web frontend.<br>\n";



if (gethostbyname("mariadb")!="mariadb")  {
        $dbhost = "mariadb";
        $dbuser = "root";
        $dbpwd = "mypassword";
        $dbname = "mydatabase";

	$connection = new mysqli($dbhost, $dbuser, $dbpwd, $dbname);
	if ($connection->connect_errno)  {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	}
	// DDL blind creation
	$rs = $connection->query("create table if not exists version  ( cur_version int not null, primary key (cur_version))");


	// Get current version
	$rs = $connection->query("select MAX(cur_version) as cur_version from version");
	if (!mysqli_num_rows($rs))  $row['cur_version'] = 0;
	else  $row = $rs->fetch_array(MYSQLI_ASSOC);
	print "Currently executing stateful data <span style='display:inline-block;background-color:yellow;padding:.2em 1em;'>version ".$row['cur_version']."</span><br>\n";

	$rs->close();
	$connection->close();
}  else  {
	print "No stateful data available<br>\n";
}


echo "<hr>\n";
echo "Serving from pod <b>".getenv('HOSTNAME')."</b>.\n";


?>
</body>
