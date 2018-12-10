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
            <h1>View Further Information</h1>
            <p>
                <?php
                include("../config.php");

                session_start();

                if ($_SESSION['username'] == NULL){
                    header("Location: login.php");
                }

                $myusername = $_SESSION['username'];
                $id_more = $_SESSION['txt_id'];

                //show rating
                $sql = "SELECT emoji FROM Rate WHERE item_id='$id_more'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    //output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo nl2br("Rating: ".$row['emoji']."\n");
                    }
                }
                else{
                    echo nl2br("Rating: 0 results\n");
                }
                echo "<hr>";
                //show first and last name of taggees whose tag status are true
                $sql2 = "SELECT DISTINCT fname,lname FROM PERSON WHERE email IN (SELECT email_tagged FROM Tag WHERE item_id=$id_more AND status='true')";
                $result2 = mysqli_query($conn, $sql2);

                if (mysqli_num_rows($result2) > 0){
                    while ($row2 = mysqli_fetch_assoc($result2)){
                        echo nl2br("First name: ".$row2['fname']." || Last name: ".$row2['lname']."\n");
                    }
                }
                else{
                    echo nl2br("Taggee Names: 0 results\n");
                }
                // tagged groups
                $sql2 = "SELECT DISTINCT fg_tagged, email_owner FROM TagFriendgroup WHERE item_id=$id_more AND status='true')";
                $result2 = mysqli_query($conn, $sql2);

                if (mysqli_num_rows($result2) > 0) {
                    while ($row2 = mysqli_fetch_assoc($result2)) {
                        $fg_tagged = $row2['fg_tagged'];
                        $email_owner = $row2['email_owner'];
                        $sql3 = "SELECT DISTINCT email_tagged FROM TagFriendgroup WHERE item_id=$id_more AND fg_tagged='$fg_tagged' AND email_owner='$email_owner' AND status='false')";
                        $result3 = mysqli_query($conn, $sql3);
                        if (mysqli_num_rows($result3) == 0) {
                            echo nl2br("Group name: " . $row2['fg_tagged'] . "\n");
                        }
                    }
                }
                $sql2 = "SELECT DISTINCT email_tagged FROM TagFriendgroup WHERE item_id=$id_more AND status='true')";
                $result2 = mysqli_query($conn, $sql2);

                mysqli_close();
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


