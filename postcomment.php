<!DOCTYPE html>
<html lang="en">
<head>
    <title>Module 3 Group</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
<?php
    require 'database.php';
    session_start();


    $user_id = $_SESSION['user_id'];
    $user_id = htmlspecialchars($user_id);

    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
    }

    $story_username = $_POST['story_username'];
    $story_title = $_POST['story_title'];
    $comment = $_POST['comment'];

    echo $story_username;
    echo $story_title;
    echo $comment;

 
    $stmt = $mysqli->prepare("insert into comments (story_username, your_username, story_title, comment) values (?, ?, ?, ?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
 
    $stmt->bind_param('ssss',  $story_username, $user_id, $story_title, $comment);
 
    $stmt->execute();
         
    $stmt->close();

    header("Location: comments.php");

?>
</body>
<html>