<?php
         require 'database.php';
         session_start();

         if(!hash_equals($_SESSION['token'], $_POST['token'])){
            die("Request forgery detected");
        }
        
         $username = $_SESSION['user_id'];
         $title = $_POST['title'];
         $body = $_POST['body'];
         $link = $_POST['link'];

 
         $stmt = $mysqli->prepare("insert into stories (username, title, body, link) values (?, ?, ?, ?)");
         if(!$stmt){
             printf("Query Prep Failed: %s\n", $mysqli->error);
             exit;
         }
         else if (!empty($_POST)){
            header("Location: main.php");
         }
 
         $stmt->bind_param('ssss',  $username, $title, $body, $link);
 
         $stmt->execute();
         
         $stmt->close();
    ?>