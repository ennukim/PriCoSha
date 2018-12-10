<?php
//CREATE TABLE TagFriendgroup (
//    'fg_tagged' varchar(20) NOT NULL,
//    'email_tagged' varchar(20) NOT NULL,
//    'email_tagger' varchar(20) NOT NULL,
//    'item_id' int(11) NOT NULL,
//    'status' varchar(20) DEFAULT NULL,
//    'tagtime' timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
//);
include "config.php";
session_start();

if ($_SESSION['username'] == NULL){
    header("Location: login.php");
}

$myusername = $_SESSION['username'];

$sql = "SELECT item_id FROM ContentItem WHERE is_pub = 1 OR item_id IN (SELECT DISTINCT item_id FROM Belong NATURAL JOIN Share NATURAL JOIN Friendgroup WHERE Belong.email = '$myusername')";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    //appends item_id that is viewable to the current user to the array
    while ($row = mysqli_fetch_assoc($result)) {
        $viewable_array[] = $row['item_id'];
    }
}

if (isset($_POST['but_submit'])){
    $fg_owner = mysqli_real_escape_string($conn, $_POST['fg_owner']);
    $tagged_fg = mysqli_real_escape_string($conn, $_POST['tagged_friendgroup']);
    $selected_item = mysqli_real_escape_string($conn, $_POST['item_id']);

    if (in_array($selected_item, $viewable_array)){
        // check if selected item is viewable by tagged fg
        $sql_check_viewable = "SELECT item_id FROM Share WHERE owner_email='$fg_owner' AND fg_name='$tagged_fg' AND item_id=$selected_item";
        $result_check_viewable = mysqli_query($conn, $sql_check_viewable);

        // check if current user is in the fg
        $sql_check_infg = "SELECT email FROM Belong WHERE owner_email='$fg_owner' AND fg_name='$tagged_fg' AND email='$myusername'";
        $result_check_infg = mysqli_query($conn, $sql_check_infg);

        if (mysqli_num_rows($result_check_viewable) > 0 && mysqli_num_rows($result_check_infg) > 0) {

            // get all members of fg
            $sql_getmembers = "SELECT email FROM Belong WHERE owner_email='$fg_owner' AND fg_name='$tagged_fg'";
            $result_getmembers = mysqli_query($conn, $sql_getmembers);
            // tag everyone in fg
            while ($row = mysqli_fetch_assoc($result_getmembers)) {
                $taggee = $row['email'];
                if ($myusername == $taggee) {
                    $tag_status = "true";
                } else {
                    $tag_status = "false";
                }
                $insert_sql = "INSERT INTO `TagFriendgroup`(`owner_email`, `fg_tagged`, `email_tagged`, `email_tagger`, `item_id`, `status`, `tagtime`) VALUES ('$fg_owner', '$tagged_fg', '$taggee', '$myusername',$selected_item,'$tag_status',now())";
                if (mysqli_query($conn, $insert_sql)) {

                } else {
                    echo "ERROR: could not execute $insert_sql";
                    echo mysqli_error($conn);
                }
            }

        }
        else {
            echo "Permission denied.";
        }
    }
    else{
        echo "Could not propose this tag because the selected content item was not viewable by $myusername";
    }
}


mysqli_close($conn);

?>

<html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style type="text/css">
    /* Style buttons */
    .btn {
        background-color: Black; /* Black background */
        border: none; /* Remove borders */
        color: white; /* White text */
        padding: 12px 16px; /* Some padding */
        font-size: 16px; /* Set a font size */
        cursor: pointer; /* Mouse pointer on hover */
        width: 5%;
    }

    /* Darker background on mouse-over */
    .btn:hover {
        background-color: DimGray;
    }

    /* Container */
    .container{
        width:40%;
        margin:0 auto;
    }

    /* Login */
    #div_tag_info{
        border: 1px solid gray;
        border-radius: 3px;
        width: 400px;
        height: 310px;
        box-shadow: 0px 2px 2px 0px  gray;
        margin: 0 auto;
    }

    #div_tag_info h1{
        margin-top: 0px;
        font-weight: normal;
        padding: 10px;
        background-color: Black;
        color: white;
        font-family: sans-serif;
    }

    #div_tag_info div{
        clear: both;
        margin-top: 10px;
        padding: 5px;
    }

    #div_tag_info [type=text]{
        width: 96%;
        padding: 7px;
    }

    #div_tag_info  [type=submit]{
        background-color:black;
        border: none;
        color: white;
        padding: 16px 32px;
        text-decoration: none;
        margin: 4px 2px;
        cursor: pointer;}
</style>
<div class="icon">
    <button class="btn" onclick="location.href='home/index.php'" type="button"><i class="fa fa-home"></i></button>
</div>
<div class="container">
    <form method="post" action="">
        <div id="div_tag_info">
            <h1>Tag Group</h1>
            <div>
                <input type="text" class="textbox" id="fg_owner" name="fg_owner" placeholder="Email of Friend Group owner" />
            </div>
            <div>
                <input type="text" class="textbox" id="tagged_friendgroup" name="tagged_friendgroup" placeholder="Tagged Friend Group" />
            </div>
            <div>
                <input type="text" class="textbox" id="item_id" name="item_id" placeholder="Item Id"/>
            </div>
            <div>
                <input type="submit" value="Submit" name="but_submit" id="but_submit" />
            </div>
            </div>
        </div>
    </form>
</div>
</html>

