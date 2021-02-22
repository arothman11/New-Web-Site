<!DOCTYPE html>
<html lang="en">
<head>
    <title>Module 3 Group</title>
    <link rel="stylesheet" href="stylesheet.css">
    <meta charset="UTF-8">
</head>
<body>
    <h1> Edit Your Story Here! </h1>
    
<?php
    require 'database.php';
    session_start();

    //getting data from form
    $title = $_POST["titledata"];
    $body = $_POST["bodydata"];
    $link = $_POST["linkdata"];
    $token = $_SESSION['token'];
    $username = $_SESSION['user_id'];

    //htmlentities
    $title = htmlentities($title);
    $body = htmlentities($body);
    $link = htmlentities($link);
    $username = htmlentities($username);

    
    //check username
    if( !preg_match('/^[\w_\-]+$/', $username) ){
        echo "Invalid username";
        exit;
    }

    //form for re-posting story
    echo 
    "<form action='poststory2.php' method='Post' id='editstory'>
        <input type='hidden' name='token' value='$token'/>
        <label for='title'>Title:</label>
        <input value='$title' type='text' name='title' id ='title'>

        <label for='body'>Story Text:</label>
        <textarea id='body' name='body' rows='30' cols='50'>$body</textarea>

        <label for='link'>Link:</label>
        <input value='$link' type='url' name='link' id ='link'>

        <button type='submit' id='logout-button'>Post Edit</button>
    </form>";

    echo "<p>Editing this post will delete all current comments. This is because editing will create new content that old comments may not apply to.</p>";
    
    //query for deleting comments from the story
    $stmt1 = $mysqli->prepare("delete from comments where story_username='$username' && story_title='$title'");
    if(!$stmt1){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt1->execute();
     
    $stmt1->close();
   
    //query for deleting the story
    $stmt2 = $mysqli->prepare("delete from stories where username='$username' && title='$title'");
        if(!$stmt2){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
 
        $stmt2->execute();
         
        $stmt2->close();
    ?>


</body>
</html>
