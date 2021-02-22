<!DOCTYPE html>
<html lang="en">
<head>
    <title>Module 3 Group</title>
    <link rel="stylesheet" href="stylesheet.css">
    <meta charset="UTF-8">
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

    if( !preg_match('/^[\w_\-]+$/', $user_id) ){
        echo "Invalid username";
        exit;
    }

    $story_username = $_POST['story_username'];
    $story_title = $_POST['story_title'];
    $comment = $_POST['comment'];

    $story_username = htmlentities($story_username);
    $story_title = htmlentities($story_title);
    $comment = htmlentities($comment);
    
 
    $stmt = $mysqli->prepare("insert into comments (story_username, your_username, story_title, comment) values (?, ?, ?, ?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
 
    $stmt->bind_param('ssss',  $story_username, $user_id, $story_title, $comment);
 
    $stmt->execute();
         
    $stmt->close();

    echo "<p>Comment Successfully Posted!</p>";
    echo '
             <form action="main.php" method="Post">
                 <button type="submit">Return to Main Page</button>
             </form>';

?>
</body>
<html>