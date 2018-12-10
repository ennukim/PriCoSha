<?php
session_start();
unset($_SESSION['tagged_id']);

if ($_SESSION['tagged_id'] == NULL){
    header('Location: manage_tag.php');
}
else{
    header('Location: home/index.php');
}

exit;
?>
