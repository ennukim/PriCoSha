<?php
include("config.php");

session_start();

if ($_SESSION['username'] == NULL){
    header("Location: login.php");
}

$myusername = $_SESSION['username'];

// take f_name, l_name, name of fg
if(isset($_POST['but_submit'])){

    $myfname = mysqli_real_escape_string($conn,$_POST['txt_fname']);
    $mylname = mysqli_real_escape_string($conn,$_POST['txt_lname']);
	$myfg = mysqli_real_escape_string($conn,$_POST['txt_fg']);;
	
    if ($myfname != "" && $mylname != "" && $myfg != ""){
		$sql = "SELECT email FROM Person WHERE fname='$myfname' AND lname='$mylname'"; // check if name exists
		$result = mysqli_query($conn, $sql);
		

		if (mysqli_num_rows($result) == 1) {
			// name exists
			$friendemail = mysqli_fetch_assoc($result)["email"];
				
				
			$sql = "SELECT fg_name FROM Friendgroup WHERE fg_name='$myfg' AND owner_email='$myusername'"; // check if FG owned by current user
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) == 1) {
				// FG exists
				$sql = "SELECT email FROM Belong WHERE fg_name='$myfg' AND owner_email='$myusername' AND email='$friendemail'"; // check name in FG
				$result = mysqli_query($conn, $sql);

				if (mysqli_num_rows($result) == 0) {
					// the name does not exist in FG
					$sql = "INSERT INTO Belong (email, owner_email, fg_name) VALUES('$friendemail', '$myusername', '$myfg')"; // Insert into Belong
					$result = mysqli_query($conn, $sql);
					echo "Your friend has been successfully added to the group.";
				}
				else {
					echo "A person with the same name already exists in the group";
				}
			}
			else {
				echo "Invalid FriendGroup name";
			}
		}
		else {
			echo "Invalid name";
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
            height: 320px;
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
        <button class="btn" onclick="location.href='home/index.php'" type="button"><i class="fa fa-home"></i></button>
    </div>
    <div class="container">
        <form method="post" action="">
            <div id="div_login">
                <h1>Add friend</h1>
                <div>
                    <input type="text" class="textbox" id="txt_fg" name="txt_fg" placeholder="Name of FriendGroup" />
                </div>
                <div>
                    <input type="text" class="textbox" id="txt_fname" name="txt_fname" placeholder="First name" />
                </div>
                <div>
                    <input type="text" class="textbox" id="txt_lname" name="txt_lname" placeholder="Last name"/>
                </div>
                <div>
                    <input type="submit" value="Submit" name="but_submit" id="but_submit" />
                </div>
            </div>
        </form>
    </div>
</html>

