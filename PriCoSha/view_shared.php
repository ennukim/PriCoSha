<?php
include("config.php");

session_start();

if ($_SESSION['username'] == NULL){
    header("Location: login.php");
}

$myusername = $_SESSION['username'];

$sql = "SELECT item_id, email_post, post_time, file_path, item_name, is_pub FROM ContentItem WHERE is_pub = 1 OR item_id IN (SELECT DISTINCT item_id FROM Belong NATURAL JOIN Share NATURAL JOIN Friendgroup WHERE Belong.email = '$myusername') ORDER BY post_time DESC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    //output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo nl2br("item_id: " . $row["item_id"] . " - email: " . $row["email_post"]." - post time: ".
            $row["post_time"]." - file path: ".$row["file_path"]." - item name: ".$row["item_name"]."\n");
    }
}
else{
    echo "0 results\n";
}

mysqli_close($conn);

?>


