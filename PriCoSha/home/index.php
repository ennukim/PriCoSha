<?php

session_start();
$myusername = $_SESSION['username'];

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
                <h1>PriCoSha</h1>
                <h3>Hello, <?php
                    if ($_SESSION['username'] == NULL){
                        echo "Welcome to PriCoSha.";
                        }
                        else{
                            echo "$myusername".",";
                    } ?></h3>
                <p>PriCoSha is a system for privately sharing content items
                    among groups of people. PriCoSha gives users somewhat more privacy than many content
                    sharing sites by giving them more detailed control over who can see which content items they
                    post and more control over whether other people can tag content items with a user’s personal
                    information.</p>
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
