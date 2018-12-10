<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "PriCoSha";

//create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

/*
//check connection
if (!$conn){
    die("Connection failed: ".mysqli_connect_error());
}
echo "connected successfully\n";
*/

?>