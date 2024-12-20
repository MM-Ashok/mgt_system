<?php
$server = "localhost";
$username = "developer";
$password = "mir_developer";
$databasename = "library_management_db";

$conn = mysqli_connect($server, $username, $password);

$abc = mysqli_select_db($conn, $databasename);

if (!$abc) {
	die("disconnect");
} else {
	//die ("successfull");
}
