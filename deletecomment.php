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

    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
    }

    $story_username = $_POST["story_username"];
    $story_title = $_POST["story_title"];
    $comment = $_POST["comment"];
    $token = $_SESSION['token'];
    $your_username = $_SESSION['user_id'];

    if( !preg_match('/^[\w_\-]+$/', $your_username) ){
        echo "Invalid username";
        exit;
    }


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