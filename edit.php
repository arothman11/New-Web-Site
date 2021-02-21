<!DOCTYPE html>
<html lang="en">
<head>
    <title>Module 3 Group</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <h1> Edit Your Story Here! </h1>
    
<?php
    require 'database.php';
    session_start();

    // if(!hash_equals($_SESSION['token'], $_POST['token'])){
    //     die("Request forgery detected");
    // }

    $title = $_POST["titledata"];
    $body = $_POST["bodydata"];
    $link = $_POST["linkdata"];
    $token = $_SESSION['token'];
    $username = $_SESSION['user_id'];


    echo 
    "<form action='edit.php' method='Post' id='editstory'>
        <input type='hidden' name='token' value='$token'/>
        <label for='title'>Title:</label>
        <input value='$title' type='text' name='title' id ='title'>

        <label for='body'>Story Text:</label>
        <textarea id='body' name='body' rows='30' cols='50'>$body</textarea>

        <label for='link'>Link:</label>
        <input value='$link' type='url' name='link' id ='link'>

        <button type='submit' id='logout-button'>Post Edit</button>
    </form>";


        $stmt1 = $mysqli->prepare("delete from stories where username='?' && title='?'");
        if(!$stmt1){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt1->bind_param('ss',  $username, $title);
 
        $stmt1->execute();
         
        $stmt1->close();


        $stmt = $mysqli->prepare("insert into stories (username, title, body, link) values (?, ?, ?, ?)");
         if(!$stmt){
             printf("Query Prep Failed: %s\n", $mysqli->error);
             exit;
         }
         else if (!empty($_POST)){
             echo "<p>Post successfully created.</p>";
             echo '
             <form action="main.php" method="Post">
                 <button type="submit">Return to Main Page</button>
             </form>';
         }
 
         $stmt->bind_param('ssss',  $username, $title, $body, $link);
 
         $stmt->execute();
         
         $stmt->close();
    ?>


</body>
</html>