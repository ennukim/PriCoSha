<?php
include "config.php";
session_start();

if ($_SESSION['username'] == NULL){
    header("Location: login.php");
}

$myusername = $_SESSION['username'];

//check if item is viewable to the current user
$sql = "SELECT item_id FROM ContentItem WHERE is_pub = 1 OR item_id IN (SELECT DISTINCT item_id FROM Belong NATURAL JOIN Share NATURAL JOIN Friendgroup WHERE Belong.email = '$myusername')";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    //appends item_id that is viewable to the current user to the array
    while ($row = mysqli_fetch_assoc($result)) {
        $viewable_array[] = $row['item_id'];
    }
}

if (isset($_POST['but_submit'])){
    $taggee = mysqli_real_escape_string($conn, $_POST['taggee_email']);
    $selected_item = mysqli_real_escape_string($conn, $_POST['item_id']);

    //check if taggee has already been tagged to the same item before
    $sql1 = "SELECT item_id FROM Tag WHERE email_tagged='$taggee' AND item_id = $selected_item";
    $result1 = mysqli_query($conn, $sql1);

    if (mysqli_num_rows($result1) > 0) {
        //output data of each row
        while ($row = mysqli_fetch_assoc($result1)) {
            $dup_array[] = $row['item_id'];
        }
    }

    if (in_array($selected_item, $viewable_array) && !in_array($selected_item, $dup_array)){
        if ($myusername == $taggee){
            $insert_sql = "INSERT INTO `Tag`(`email_tagged`, `email_tagger`, `item_id`, `status`, `tagtime`) VALUES ('$myusername','$myusername',$selected_item,'true',now())";
            if (mysqli_query($conn, $insert_sql)){
                echo "Record inserted successfully.";
            }
            else{
                echo "ERROR: could not able to execute $insert_sql";
                echo mysqli_error($conn);
            }
        }
        else{
            $insert_sql = "INSERT INTO `Tag`(`email_tagged`, `email_tagger`, `item_id`, `status`, `tagtime`) VALUES ('$taggee','$myusername',$selected_item,'false',now())";
            if (mysqli_query($conn, $insert_sql)){
                echo "Record inserted successfully.";
            }
            else{
                echo "ERROR: could not able to execute $insert_sql<br>";
                echo mysqli_error($conn);
            }
        }
    }
    else if (in_array($selected_item, $viewable_array) && in_array($selected_item, $dup_array)){
        echo "Taggee has already been tagged to the same ID";
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
        width: 300px;
        height: 260px;
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
            <h1>Tag</h1>
            <div>
                <input type="text" class="textbox" id="taggee_email" name="taggee_email" placeholder="Taggee Email" />
            </div>
            <div>
                <input type="text" class="textbox" id="item_id" name="item_id" placeholder="Item Id"/>
            </div>
            <div>
                <input type="submit" value="Submit" name="but_submit" id="but_submit" />
            </div>
        </div>
    </form>
</div>
</html>


