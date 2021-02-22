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

    $username = $_SESSION['user_id'];
    if( !preg_match('/^[\w_\-]+$/', $username) ){
        echo "Invalid username";
        exit;
    }


    $stmt1 = $mysqli->prepare("delete from comments where your_username='$username'");
    if(!$stmt1){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt1->execute();
     
    $stmt1->close();

    $stmt3 = $mysqli->prepare("delete from comments where story_username='$username'");
    if(!$stmt3){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt3->execute();
     
    $stmt3->close();

    $stmt2 = $mysqli->prepare("delete from stories where username='$username'");
    if(!$stmt2){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt2->execute();
     
    $stmt2->close();

    


    $stmt = $mysqli->prepare("delete from users where username='$username'");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
 
        $stmt->execute();
         
        $stmt->close();

        echo "<p>Account Successfully Deleted!</p>";
        echo '
                 <form action="login.php" method="Post">
                     <button type="submit">Return to Login Page</button>
                 </form>';

?>

    </body>
    </html>