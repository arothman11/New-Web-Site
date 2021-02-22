<!DOCTYPE html>
<html lang="en">
<head>
    <title>Module 3 Group</title>
    <link rel="stylesheet" href="stylesheet.css">
    <meta charset="UTF-8">
</head>
<body>
    <h1>Welcome To Your News Site</h1>
        
     <!-- //logout button -->
    <form action="logout.php" method="Post" id="logout">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        <button type="submit" id="logout-button">Log Out</button>
    </form>

    <!-- //form to post a story -->
    <form action="poststory.php" method="Post" id="poststory">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        <button type="submit">Post Story</button>
    </form>


<?php
    require 'database.php';
    session_start();

    $user_id = (string)$_SESSION['user_id'];
    $user_id = htmlspecialchars($user_id);

    //check username
    if( !preg_match('/^[\w_\-]+$/', $user_id) ){
        echo "Invalid username";
        exit;
    }
      
    //token variable
    $sestok = $_SESSION["token"];

    echo "<h2>You Are Logged In As: </h2>";
    echo "<form action='userprofile.php' method='Post'>
                <input type='hidden' name='username' value='$user_id'>
                <button type='submit' name='useracct' id='useracct'>$user_id</button>
            </form>";
        
    //delete user button
    echo "<form action='deleteuser.php' method='Post'>
                <input type='hidden' name='token' value='$sestok'/>
                <button type='submit' name='deleteuser' class='deleteuser'>Delete Your Account</button>
            </form>";

    //query for getting stories
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

    
    //fetching all stories
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

        
        //if this post was posted by the user that is currently logged in
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
        
        //button for adding or viewing comments
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
