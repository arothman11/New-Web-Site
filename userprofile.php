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
 
     $username = $_SESSION['user_id'];
     if( !preg_match('/^[\w_\-]+$/', $username) ){
        echo "Invalid username";
        exit;
    }
    
     $userprofile = $_POST['username'];

     echo "<h1>Welcome to $userprofile 's profile</h1>";

     echo '
             <form action="main.php" method="Post">
                 <button type="submit">Return to Main Page</button>
             </form>';

     $stmt = $mysqli->prepare("select * from stories where username='$userprofile'");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    
    $stmt->execute();
    
    $stmt->bind_result($username, $title, $body, $link);

    $username = htmlentities($username);
    $title = htmlentities($title);
    $body = htmlentities($body);
    $link = htmlentities($link);

    
    
    while($stmt->fetch()){
        echo "<div class='story'>\n";
        printf(
            "
            <form action='userprofile.php' method='Post'>
                <input type='hidden' name='username' value=%s>
                <label for='useracct'>Posted By:</label>
                <button type='submit' name='useracct' class='useracct'>%s</button>
            </form>
            <h3 class='storytitle'>%s</h3>
            <p class='storybody'>%s</p>
            <a href=%s class='storylink'>%s</a>",
            $username, $username, $title, $body, $link, $link
        );

        

        if($username == $userprofile){
            
            echo
                "<form action='edit.php' method='Post'>
                    <input type='hidden' name='titledata' value='$title'></input>
                    <input type='hidden' name='bodydata' value='$body'></input>
                    <input type='hidden' name='linkdata' value='$link'></input>
                    
                    <button type='submit' name='editbtn' class='editbtn'>Edit Post</button>
                </form>";
            
            echo
                "<form action='deletepost.php' method='Post'>
                    <input type='hidden' name='titledata' value='$title'></input>
                    <input type='hidden' name='bodydata' value='$body'></input>
                    <input type='hidden' name='linkdata' value='$link'></input>
                    <input type='hidden' name='token' value='$sestok'/>
                    <button type='submit' name='deletetbn' class='deletebtn'>Delete Post</button>
                </form>";


        }

        echo "<form action='comments.php' method='Post'>
                    <input type='hidden' name='titledata' value='$title'></input>
                    <input type='hidden' name='postusername' value='$username'></input>
                    <button type='submit' name='comments' class='comments'>View & Post Comments Here!</button>
                </form>";


    echo "</div>\n";
    }
    
    
    $stmt->close();

?>


</body>
<html>