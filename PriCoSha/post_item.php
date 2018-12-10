<?php
include "config.php";
session_start();

if ($_SESSION['username'] == NULL){
    header("Location: login.php");
}

$myusername = $_SESSION['username'];

$is_pub = $_POST['privacy'];
settype($is_pub, 'integer');

if (isset($_POST['but_submit']) && $is_pub == 1) {
    $file_path = mysqli_real_escape_string($conn, $_POST['file_path']);
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);

    $sql = "INSERT INTO `ContentItem`(`email_post`, `post_time`, `file_path`, `item_name`, `is_pub`) VALUES ('$myusername',now(), '$file_path', '$item_name', $is_pub)";
    $result = mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0){
        echo "New content item has been added successfully.";
    }
    else{
        echo "Error: ".mysqli_error($conn);
    }
}

if (isset($_POST['but_submit']) && $is_pub == 0){
    $file_path = mysqli_real_escape_string($conn, $_POST['file_path']);
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);

    $sql = "INSERT INTO `ContentItem`(`email_post`, `post_time`, `file_path`, `item_name`, `is_pub`) VALUES ('$myusername',now(), '$file_path', '$item_name', $is_pub)";
    $result = mysqli_query($conn, $sql);

//    if (mysqli_affected_rows($conn) > 0){
//        echo "New content item has been added successfully.";
//    }
//    else{
//        echo "Error: ".mysqli_error($conn);
//    }
    $sql2 = "SELECT MAX(item_id) FROM ContentItem";
    $result2 = mysqli_query($conn, $sql2);
    $row = mysqli_fetch_array($result2);
    $_SESSION['latest_item'] = $row[0];
    header('Location: post_item_private.php');
}




?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Style buttons */
        .btn {
            background-color: Black; /* Black background */
            margin: 8px 0;
            border: none; /* Remove borders */
            color: white; /* White text */
            padding: 12px 16px; /* Some padding */
            font-size: 16px; /* Set a font size */
            cursor: pointer; /* Mouse pointer on hover */
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: dimgray;
        }

        * {
            box-sizing: border-box;
        }

        /* Add padding to containers */
        .container {
            padding: 16px;
            background-color: white;
        }

          /* Full-width input fields */
        input[type=text]{
            width: 70%;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
        }

        input[type=text]:focus {
            background-color: #ddd;
            outline: none;
        }

        /* Overwrite default styles of hr */
        hr {
            border: 1px solid #f1f1f1;
            margin-bottom: 25px;
        }

        /* Set a style for the submit button */
        .upload-button {
            background-color: black;
            color: white;
            padding: 16px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            align-self: center;
            width: 15%;
            opacity: 1.0;
        }

        .upload-button:hover {
            opacity: 0.7;
        }

        /* Add a blue text color to links */
        a {
            color: dodgerblue;
        }

    </style>
</head>
<body>
<div class="icon">
    <button class="btn" onclick="location.href='home/index.php'" type="button"><i class="fa fa-home"></i></button>
</div>
<form method="post" action="">
    <div class="container">
        <h1>Post Content Item</h1>
        <p>Please fill in this form to post a content item.<br>
            (If you choose your item to be private, you will be redirected to a new page where you can share your content item with your friend groups.)
        </p>
        <hr>

        <label for="file_path"><b>File Path</b></label><br>
        <input type="text" placeholder="Enter file path" name="file_path" required><br>

        <label for="item_name"><b>Item Name</b></label><br>
        <input type="text" placeholder="Enter item name" name="item_name" required><br>

        <label for="privacy"><b>Privacy Setting</b></label><br>
        <select name="privacy" id="privacy">
            <option value="0">Private</option>
            <option value="1">Public</option>
        </select>

        <hr>
        <button type="submit" class="upload-button" name="but_submit">Upload</button>
    </div>
</form>

</body>
</html>

