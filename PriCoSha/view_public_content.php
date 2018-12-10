<html>
<body>
    <h1>View Public Content</h1>
    <?php
    include ("config.php");

    $sql = "SELECT item_id, email_post, post_time, file_path, item_name FROM ContentItem WHERE is_pub = 1 
            AND post_time >= DATE_SUB(NOW(), INTERVAL 1 DAY);";
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
</body>
</html>
