<!DOCTYPE html>
<html lang="en">
<head>
    <title>Module 3 Group</title>
    <link rel="stylesheet" href="stylesheet.css">
    <meta charset="UTF-8">
</head>
<body>
    <h1> Edit Your Comment Here! </h1>
    
    

<?php
    require 'database.php';
    session_start();
    
    //check token
    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
    }

    //get data from form
    $story_username = $_POST["story_username"];
    $story_title = $_POST["story_title"];
    $comment = $_POST["comment"];
    $token = $_SESSION['token'];
    $your_username = $_SESSION['user_id'];

    //htmlentities
    $story_username = htmlentities($story_username);
    $story_title = htmlentities($story_title);
    $comment = htmlentities($comment);
    $your_username = htmlentities($your_username);

    //checking username
    if( !preg_match('/^[\w_\-]+$/', $your_username) ){
        echo "Invalid username";
        exit;
    }
    

    $sestok =$_SESSION['token'];

    //form for posting a comment
    echo 
       "<form action='postcomment.php' method='Post' id='postcomment'>
           <input type='hidden' name='story_username' value='$story_username' />
            <input type='hidden' name='story_title' value='$story_title' />
            <input type='hidden' name='token' value='$sestok' />
            <input type='text' name='comment' value ='$comment'>
            <button type='submit'>Post Comment</button>
        </form>";

   

    //query for deleting comments 
    $stmt = $mysqli->prepare("delete from comments where your_username='$your_username' && story_username='$story_username' && story_title='$story_title' && comment='$comment'");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
 
        $stmt->execute();
         
        $stmt->close();

?>

    </body>
    </html>
