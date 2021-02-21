<!DOCTYPE html>
<html lang="en">
<head>
    <title>Module 3 Group</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <h1>Welcome To Your News Site<h1>
    <form action="logout.php" method="Post" id="logout">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        <button type="submit" id="logout-button">Log Out</button>
    </form>

    
    <form action="poststory.php" method="Post" id="poststory">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        <button type="submit" id="logout-button">Post Story</button>
    </form>


<?php
    require 'database.php';
    session_start();


    $user_id = (string)$_SESSION['user_id'];
    $user_id = htmlspecialchars($user_id);

    echo "<h2>$user_id</h2>";

    $stmt = $mysqli->prepare("select * from stories");
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
            "<h4 class='storyuser'>%s</h4>
            <h3 class='storytitle'>%s</h3>
            <p class='storybody'>%s</p>
            <a href=%s class='storylink'>%s</a>",
            $username, $title, $body, $link, $link
        );

        $sestok = $_SESSION["token"];

        if($user_id == $username){
            
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
</html>