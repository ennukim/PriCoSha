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
                <a href="add_archive.php">Add to Archive</a>
            </li>
            <li>
                <a href="archive.php">Archive</a>
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
            <h1>View Archived Items</h1>
            <p>
                <?php
                include("../config.php");

                session_start();

                if ($_SESSION['username'] == NULL){
                    header("Location: login.php");
                }

                $myusername = $_SESSION['username'];

                $sql3 = "SELECT item_id FROM Archive WHERE email_archive='$myusername'";
                $result3 = mysqli_query($conn, $sql3);

                if (mysqli_num_rows($result3) > 0) {
                    //output data of each row
                    while ($row = mysqli_fetch_assoc($result3)) {
                        echo nl2br("Item ID: ".$row['item_id']."\n");
                    }
                }
                else{
                    echo "No items archived.\n";
                }
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


