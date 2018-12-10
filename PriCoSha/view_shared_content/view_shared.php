<?php
include("../config.php");

session_start();

if ($_SESSION['username'] == NULL){
    header("Location: login.php");
}

$myusername = $_SESSION['username'];

$sql2 = "SELECT item_id FROM ContentItem WHERE is_pub = 1 OR item_id IN (SELECT DISTINCT item_id FROM Belong NATURAL JOIN Share NATURAL JOIN Friendgroup WHERE Belong.email = '$myusername') ORDER BY post_time DESC";
$result2 = mysqli_query($conn, $sql2);

if (isset($_POST['but_submit'])){
    $id_more = $_SESSION['txt_id'];
    header('Location: view_further_info.php');
}

?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PriCoSha</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/simple-sidebar.css" rel="stylesheet">

</head>

<body>

<div id="wrapper">

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="../login.php">
                    Login
                </a>
            </li>
            <li class="sidebar-brand">
                <a href="../logout.php">
                    Logout
                </a>
            </li>
            <li>
                <a href="../view_public_content/view_public_content.php">View Public Content</a>
            </li>
            <li>
                <a href="../view_shared_content/view_shared.php">View Shared Content</a>
            </li>
            <li>
                <a href="../tag_content_item.php">Tag Content Item</a>
            </li>
            <li>
                <a href="../manage_tag.php">Manage Tag</a>
            </li>
            <li>
                <a href="../friend.php">Add Friend to the Group</a>
            </li>
            <li>
                <a href="../defriend.php">Remove from the Group</a>
            </li>
            <li>
                <a href="../post_item.php">Post Content Item</a>
            </li>
            <li>
                <a href="../tag_group.php">Tag Group</a>
            </li>
            <li>
                <a href="../archive/add_archive.php">Add to Archive</a>
            </li>
            <li>
                <a href="../archive/archive.php">Archive</a>
            </li>
            <li>
                <a href="../comment.php">Add Comment</a>
            </li>
            <li>
                <a href="../view_comment.php">View Comment</a>
            </li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <h3>Enter the item id you want to see further information.</h3>
            <form method="post" action="">
                <div id="div_login">
                    <div>
                        <input type="text" class="textbox" id="txt_id" name="txt_id" placeholder="Item ID" required/>
                        <input type="submit" value="Submit" name="but_submit" id="but_submit" />
                    </div>
                </div>
            </form>
            <br>
            <hr>
            <h1>View Shared Content</h1>
            <p>
                <?php
                include("../config.php");

                session_start();

                if ($_SESSION['username'] == NULL){
                    header("Location: login.php");
                }

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
            </p>
            <a href="#menu-toggle" class="btn btn-secondary" id="menu-toggle">View Menu</a>
        </div>

    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>

</body>

</html>

