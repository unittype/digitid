<?php
/*

Get session_created user data 

*/
$user = $class->enc($_SESSION['username']);
$sql = "select * from users where username = '$user'";
$rew = pg_query($db, $sql);

if (pg_num_rows($rew) == 1) {
	$row = pg_fetch_all($rew);
	$results = array();
	foreach ($row as $key => $value) {
		array_push($results, $value);
	}
	pg_close($db);
	$ready = $results[0];
}
$profile  = array();
foreach ($ready as $key => $value) {
	$profile[$key] = $value;
}
?>
