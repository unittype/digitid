<?php

$user = $class->enc($_SESSION['client']);

$sql = "select * from clients where company_name = '$user'";
$row = pg_query($db, $sql);


if (pg_num_rows($row) == 1) {
	$row = pg_fetch_all($row);
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
