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

    if( !preg_match('/^[\w_\-]+$/', $username) ){
        echo "Invalid username";
        exit;
    }

    $stmt1 = $mysqli->prepare("delete from comments where story_username='$username' && story_title='$title'");
        if(!$stmt1){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
 
        $stmt1->execute();
         
        $stmt1->close();

    $stmt = $mysqli->prepare("delete from stories where username='$username' && title='$title'");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
 
        $stmt->execute();
         
        $stmt->close();

        header("Location: main.php");
?>