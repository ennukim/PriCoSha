<?php
include "config.php";

if(isset($_POST['but_submit'])){

    $myusername = mysqli_real_escape_string($conn,$_POST['txt_uname']);
    $mypassword = mysqli_real_escape_string($conn,$_POST['txt_pwd']);

    if ($myusername != "" && $mypassword != ""){

        $sql_query = "SELECT count(*) AS cntUser FROM Person WHERE email='$myusername' AND password=sha2('$mypassword',256)";
        $result = mysqli_query($conn,$sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['cntUser'];

        if($count > 0){
            $_SESSION['username'] = $myusername;
            header('Location: home.php');
        }else{
            echo "Invalid username or password";
        }
    }
}

?>


<html>
    <style type="text/css">
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
            height: 270px;
            box-shadow: 0px 2px 2px 0px  gray;
            margin: 0 auto;
        }

        #div_login h1{
            margin-top: 0px;
            font-weight: normal;
            padding: 10px;
            background-color: cornflowerblue;
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

        #div_login <inpu></inpu>t[type=submit]{
                               padding: 7px;
                               width: 100px;
                               background-color: lightseagreen;
                               border: 0px;
                               color: white;}
    </style>
    <div class="container">
        <form method="post" action="">
            <div id="div_login">
                <h1>Login</h1>
                <div>
                    <input type="text" class="textbox" id="txt_uname" name="txt_uname" placeholder="Username" />
                </div>
                <div>
                    <input type="password" class="textbox" id="txt_uname" name="txt_pwd" placeholder="Password"/>
                </div>
                <div>
                    <input type="submit" value="Submit" name="but_submit" id="but_submit" />
                </div>
            </div>
        </form>
</div>
</html>