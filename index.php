<html>
<head>


<style>
.speech-bubble {
    position: relative;
    background: #00aabb;
    border-radius: .4em;
    color: white;
    text-shadow: 0 -0.01em 0.01em rgba(0,0,0,.3);
}

/*
.speech-bubble:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 0;
    border: 37px solid transparent;
    border-top-color: #00aabb;
    border-bottom: 0;
    border-right: 0;
    margin-left: -18.5px;
    margin-bottom: -37px;
}
*/

.speech-bubble h1 {
    margin: 0;
    font-size: 150%;
    font-family: sniglet;
}

h1 {
    display: block;
    font-size: 2em;
    margin-block-start: 0.67em;
    margin-block-end: 0.67em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
}

.speech-bubble h2 {
    margin: 0;
    font-size: 40%;
    font-weight: normal;
}


</style>

</head>

<body style="font-size: 3em;">
<?php




//echo "Welcome to my stateless web frontend.<br>\n";



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
	//print "Currently executing stateful data <span style='display:inline-block;background-color:yellow;padding:.2em 1em;'>version ".$row['cur_version']."</span><br>\n";
	$state = "Currently executing stateful data <span style='display:inline-block;background-color:yellow;padding:.2em 1em;color:black;'>version ".$row['cur_version']."</span><br>\n";

	$rs->close();
	$connection->close();
}  else  {
	//print "No stateful data available<br>\n";
	$state = false;
}


//$state = "Currently executing stateful data <span style='display:inline-block;background-color:yellow;padding:.2em 1em;color:black'>version 8</span><br>\n";

?>

<?php if ($state)  { ?>
<div style="position:relative;background-position:center;background-repeat:no-repeat;background-size:cover;width:100%;height:100%;background-image: url('man_hut.png'); ">
  <hgroup class="speech-bubble" style="width:13em;padding:.5em;position: absolute;left: 2em;top: 1em;">
    <h1>Look, No Dragons!</h1>
    <h2><?php echo $state;?></h2>

  </hgroup>
</div>

<?php }  else  { ?>
<div style="position:relative;background-position:center;background-repeat:no-repeat;background-size:cover;width:100%;height:100%;background-image: url('man_boat.png'); ">
  <hgroup class="speech-bubble" style="width:10em;padding:.5em;position: absolute;right: 2em;top: 1em;">
    <h1>Thar Be Alone!</h1>
    <h2>No stateful data available</h2>
    <h2>Serving fgrom pod <b><?php echo getenv('HOSTNAME');?></b>.</h2>

  </hgroup>
</div>


<?php } ?>

</body>
</html>