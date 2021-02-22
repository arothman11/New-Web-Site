<!DOCTYPE html>
<html lang="en">
<head>
    <title>Module 3 Group</title>
    <link rel="stylesheet" href="stylesheet.css">
    <meta charset="UTF-8">
</head>
<body>
    <h1>Comments<h1>
    <form action="logout.php" method="Post" id="logout">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        <button type="submit" id="logout-button">Log Out</button>
    </form>

    

    <?php
    require 'database.php';
    session_start();

    $user_id = $_SESSION['user_id'];
    $user_id = htmlspecialchars($user_id);

    if( !preg_match('/^[\w_\-]+$/', $user_id) ){
        echo "Invalid username";
        exit;
    }

    $posted_story_username = $_POST['postusername'];
    $posted_story_title = $_POST['titledata'];

    $sestok =$_SESSION['token'];

    echo "<h2>Story Title: $posted_story_title </h2>";
            echo "<p>Posted By: $posted_story_username </p>";
            echo 
                "<form action='postcomment.php' method='Post' id='postcomment'>
                    <input type='hidden' name='story_username' value='$posted_story_username' />
                    <input type='hidden' name='story_title' value='$posted_story_title' />
                    <input type='hidden' name='token' value='$sestok' />
                    <input type='text' name='comment'>
                    <button type='submit'>Post Comment</button>
                </form>";

    $stmt = $mysqli->prepare("select * from comments where story_username='$posted_story_username' && story_title='$posted_story_title'");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    
    $stmt->execute();
    
    $stmt->bind_result($story_username, $your_username, $story_title, $comment, $count);

    $story_username = htmlentities($story_username);
    $your_username = htmlentities($your_username);
    $story_title = htmlentities($story_title);
    $comment = htmlentities($comment);
    $count = htmlentities($count);

    
    
    $int =0;

    while($stmt->fetch()){

        if ($int == 0) {
            
            echo "<ul>";
        }
        echo "<li>";
        echo $your_username;
        echo " says: ";
        echo $comment;

        if($user_id == $your_username){
            
            echo
                "<form action='editcomment.php' method='Post'>
                    <input type='hidden' name='story_username' value='$story_username' />
                    <input type='hidden' name='story_title' value='$story_title' />
                    <input type='hidden' name='comment' value='$comment' />
                    <input type='hidden' name='token' value='$sestok' />
                    
                    <button type='submit' name='editbtn' class='editbtn'>Edit Comment</button>
                </form>";
            
            echo
                "<form action='deletecomment.php' method='Post'>
                    <input type='hidden' name='story_username' value='$story_username' />
                    <input type='hidden' name='story_title' value='$story_title' />
                    <input type='hidden' name='comment' value='$comment' />
                    <input type='hidden' name='token' value='$sestok' />
                    <button type='submit' name='deletetbn' class='deletebtn'>Delete Comment</button>
                </form>";


        }


        echo "</li>";
         $int =  $int +1;
    }
    
    echo "</ul>";

    echo '
             <form action="main.php" method="Post">
                 <button type="submit">Return to Main Page</button>
             </form>';
    
    $stmt->close();

?>

</body>
<html>