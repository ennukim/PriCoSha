<?php
include("config.php");

session_start();

if ($_SESSION['username'] == NULL){
    header("Location: login.php");
}

$myusername = $_SESSION['username'];

if(isset($_POST['but_submit'])){

    $item_id = mysqli_real_escape_string($conn,$_POST['txt_id']);

    if ($item_id != ""){

        $sql = "SELECT item_id FROM ContentItem WHERE is_pub = 1 OR item_id IN (SELECT DISTINCT item_id FROM Belong NATURAL JOIN Share NATURAL JOIN Friendgroup WHERE Belong.email = '$myusername')";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            //appends item_id that is viewable to the current user to the array
            while ($row = mysqli_fetch_assoc($result)) {
                $viewable_array[] = $row['item_id'];
            }
            if (in_array($item_id, $viewable_array)){

                // fetch comments
                $sql = "SELECT item_id, email, comment_time, text FROM Comment WHERE item_id=$item_id ORDER BY comment_time DESC";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    //output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo nl2br("item_id: " . $row["item_id"] . " - email: " . $row["email_post"]." - post time: ".
                            $row["comment_time"]." - comment: ".$row["text"]."\n");
                    }
                }
            }
            else {
                echo "You cannot view this item.";
            }
        }

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
    #div_login{
        border: 1px solid gray;
        border-radius: 3px;
        width: 470px;
        height: 220px;
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
        cursor: pointer;
    }
</style>
<div class="icon">
    <button class="btn"><i class="fa fa-home"></i> <a href="home/index.php"></a></button>
</div>
<div class="container">
    <form method="post" action="">
        <div id="div_login">
            <h1>View Comment</h1>
            <div>
                <input type="text" class="textbox" id="txt_item" name="txt_item" placeholder="Item id" />
            </div>
            <div>
                <input type="submit" value="Submit" name="but_submit" id="but_submit" />
            </div>
        </div>
    </form>
</div>
</html>

