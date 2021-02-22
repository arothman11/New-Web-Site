<?php

//this file is part 2 of posting stories. It was cleaner to split this file into two. 

         require 'database.php';
         session_start();
         
         //check token
         if(!hash_equals($_SESSION['token'], $_POST['token'])){
            die("Request forgery detected");
        }
         
         //get data from form
         $username = $_SESSION['user_id'];
         $title = $_POST['title'];
         $body = $_POST['body'];
         $link = $_POST['link'];
         
         //htmlentities
         $username = htmlentities($username);
         $title = htmlentities($title);
         $body = htmlentities($body);
         $link = htmlentities($link);

         //check username
         if( !preg_match('/^[\w_\-]+$/', $username) ){
            echo "Invalid username";
            exit;
        }

         //query for posting stories
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
