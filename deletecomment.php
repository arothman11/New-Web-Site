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
    
    //checking token
    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
    }
    
    //gradbbing data from form 
    $story_username = $_POST["story_username"];
    $story_title = $_POST["story_title"];
    $comment = $_POST["comment"];
    $token = $_SESSION['token'];
    $your_username = $_SESSION['user_id'];
    
    //htmlentities
    $story_username = htmlentities("story_username");
    $story_title = htmlentities("story_title");
    $comment = htmlentities("comment");
    $your_username = htmlentities('user_id');

    //checking username
    if( !preg_match('/^[\w_\-]+$/', $your_username) ){
        echo "Invalid username";
        exit;
    }

    //query to delete comment
    $stmt = $mysqli->prepare("delete from comments where your_username='$your_username' && story_username='$story_username' && story_title='$story_title' && comment='$comment'");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
 
        $stmt->execute();
         
        $stmt->close();

        echo "<p>Comment Successfully Deleted!</p>";
        echo '
             <form action="main.php" method="Post">
                 <button type="submit">Return to Main Page</button>
             </form>';
?>
</body>
</html>
