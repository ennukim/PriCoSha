<?php
include "config.php";
session_start();

if ($_SESSION['username'] == NULL){
    header("Location: login.php");
}

$myusername = $_SESSION['username'];
$latest_item = $_SESSION['latest_item'];

$sql = "SELECT owner_email, fg_name FROM Belong WHERE email='$myusername'";
$result = mysqli_query($conn, $sql);

if (isset($_POST['but_submit'])) {
    $owner_email = mysqli_real_escape_string($conn, $_POST['txt_owner_email']);
    $fg_name = mysqli_real_escape_string($conn, $_POST['txt_fgname']);

    $sql = "INSERT INTO `Share`(`owner_email`, `fg_name`, `item_id`) VALUES ('$owner_email','$fg_name','$latest_item')";
    $result = mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0){
        echo "Your private content item has been added successfully.";
    }
    else{
        echo "Error: ".mysqli_error($conn);
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
        width:40%;
        margin:0 auto;
    }

    /* Login */
    #div_login{
        border: 1px solid gray;
        border-radius: 3px;
        width: 550px;
        height: 270px;
        box-shadow: 0px 2px 2px 0px  gray;
        margin: 0 auto;
    }

    #div_login h1{
        margin-top: 0px;
        font-weight: normal;
        padding: 10px;
        background-color: Black;
        color: white;
        font-family: sans-serif;
    }

    #div_login div{
        clear: both;
        margin-top: 10px;
        padding: 5px;
    }

    #div_login .textbox{
        width: 96%;
        padding: 7px;
    }

    #div_login  [type=submit]{
        background-color:black;
        border: none;
        color: white;
        padding: 16px 32px;
        text-decoration: none;
        margin: 4px 2px;
        cursor: pointer;}

    #candidates{
        text-align: center;
        font-family: sans-serif;
    }

    /* Overwrite default styles of hr */
    hr {
        border: 1px solid lightgray;
        margin-bottom: 25px;
    }

</style>
<div class="icon">
    <button class="btn"><i class="fa fa-home"></i> <a href="home/index.php"></a></button>
</div>
<div class="container">
    <form method="post" action="">
        <div id="div_login">
            <h1>Share Item with Friend Groups</h1>
            <div>
                <input type="text" class="textbox" id="txt_owner_email" name="txt_owner_email" placeholder="Owner Email" required/>
            </div>
            <div>
                <input type="text" class="textbox" id="txt_fgname" name="txt_fgname" placeholder="Friend Group Name" required/>
            </div>
            <div>
                <input type="submit" value="Submit" name="but_submit" id="but_submit" />
            </div>
        </div>
    </form>
</div>
<br><hr>
<div id="candidates">
    <p>
        <?php
        $sql = "SELECT owner_email, fg_name FROM Belong WHERE email='$myusername'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            //output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                echo nl2br("Owner Email: ".$row['owner_email']." || Friend Group Name: ".$row['fg_name']);
            }
        }
        else{
            echo "You don't belong to any friend groups.";
        }
        ?>
    </p>
</div>
</html>

