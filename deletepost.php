<?php
    require 'database.php';
    session_start();

    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
    }

    $title = $_POST["titledata"];
    $body = $_POST["bodydata"];
    $link = $_POST["linkdata"];
    $token = $_SESSION['token'];
    $username = $_SESSION['user_id'];

    $stmt = $mysqli->prepare("delete from stories where username='$username' && title='$title'");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('ss',  $username, $title);
 
        $stmt->execute();
         
        $stmt->close();
?>