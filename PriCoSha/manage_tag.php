<?php
include "config.php";
session_start();

if ($_SESSION['username'] == NULL){
    header("Location: login.php");
}

if (isset($_POST['but_submit'])){
    $_SESSION['tagged_id'] = $_POST['selected_id'];
    header('Location: manage_tag_each.php');
}

$myusername = $_SESSION['username'];

// individual tag
$sql = "SELECT DISTINCT item_id FROM Tag WHERE email_tagged = '$myusername' AND status = 'false'";
$result = mysqli_query($conn, $sql);

// group tag
$sql_fg = "SELECT DISTINCT item_id FROM TagFriendgroup WHERE email_tagged = '$myusername' AND status = 'false'";
$result_fg = mysqli_query($conn, $sql_fg);
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
    #div_tag{
        border: 1px solid gray;
        border-radius: 3px;
        width: 370px;
        height: 180px;
        box-shadow: 0px 2px 2px 0px  gray;
        margin: 0 auto;
    }

    #div_tag h1{
        margin-top: 0px;
        font-weight: normal;
        padding: 10px;
        background-color: Black;
        color: white;
        font-family: sans-serif;
        text-align: center;
    }

    #div_tag div{
        clear: both;
        margin-top: 10px;
        padding: 5px;
    }

    #div_tag  [type=submit]{
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
        <div id="div_tag">
            <h1>Tagged Item ID List</h1>
            <select name="selected_id" id="selected_id">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    //output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        $each_id = $row["item_id"];
                        $id_array[] = $row['item_id'];
                        echo "<option value='$each_id'>$each_id</option>";
                    }
                }
                else{
                    echo "0 results";
                }
                ?>
            </select>
            <div>
                <input type='submit' value='Submit' name='but_submit' id='but_submit'>
            </div>
        </div>
    </form>
</div>
</html>