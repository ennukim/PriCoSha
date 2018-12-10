<?php
include "config.php";

session_start();

if ($_SESSION['username'] == NULL){
    header('Location: login.php');
}

$myusername = $_SESSION['username'];
$selected_id = $_SESSION['tagged_id'];

if (isset($_POST['but_submit'])){
    if ($_POST['status'] == "accept"){
        $sql = "UPDATE `Tag` SET `status`='true' WHERE email_tagged='$myusername' AND item_id=$selected_id";
        $result = mysqli_query($conn, $sql);
        $sql_fg = "UPDATE `TagFriendgroup` SET `status`='true' WHERE email_tagged='$myusername' AND item_id=$selected_id";
        $result_fg = mysqli_query($conn, $sql_fg);
        echo "Your tag status has successfully been changed to 'true'.";
    }
    else if ($_POST['status'] == "decline"){
        $sql = "DELETE FROM `Tag` WHERE email_tagged='$myusername' AND item_id=$selected_id";
        $result = mysqli_query($conn, $sql);

        $sql = "SELECT fg_tagged, owner_email FROM TagFriendgroup WHERE email_tagged='$myusername' AND item_id=$selected_id";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            //output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                $fg_owner = $row["owner_email"];
                $fg_tagged = $row["fg_tagged"];
                $sql_fg = "DELETE FROM `TagFriendgroup` WHERE fg_tagged='$fg_tagged' AND owner_email='$fg_owner' AND item_id=$selected_id";
                $result_fg = mysqli_query($conn, $sql_fg);
            }
        }


        echo "Your tag status has successfully been removed.";
    }
    else{
        echo "Your tag status will remain the same";
    }
}
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
        width:25%;
        margin:0 auto;
    }

    /* Tag */
    #div_status{
        border: 1px solid gray;
        border-radius: 3px;
        width: 370px;
        height: 180px;
        box-shadow: 0px 2px 2px 0px  gray;
        margin: 0 auto;
    }

    #div_status h1{
        margin-top: 0px;
        font-weight: normal;
        padding: 10px;
        background-color: Black;
        color: white;
        font-family: sans-serif;
        text-align: center;
    }

    #div_status div{
        clear: both;
        margin-top: 10px;
        padding: 5px;
    }

    #div_status [type=submit]{
        position: absolute;
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
        <div id="div_status">
            <h1>Manage Tag Status</h1>
            <select name="status" id="status">
                <option value="accept">Accept</option>
                <option value="decline">Decline</option>
                <option value="ignore">Ignore</option>
            </select>
            </select>
            <div>
                <input type='submit' value='Submit' name='but_submit' id='but_submit'>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    document.getElementById("redirect-button").onclick = function () {
        location.href = "destroy_ses_var.php";
    };
</script>
</html>