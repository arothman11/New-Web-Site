<!DOCTYPE html>
<html lang="en">
<head>
    <title>Module 3 Group</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>

    <form action="logout.php" method="Post" id="logout">
        <button type="submit" id="logout-button">Log Out</button>
    </form>

    <h1>Welcome To Your News Site<h1>
    <form action="poststory.php" method="Post" id="poststory">
        <button type="submit" id="logout-button">Post Story</button>
    </form>


   

<?php
    require 'database.php';
    session_start();
    $user_id = $_SESSION['user_id'];

    echo"<h2>$user_id</h2>";

    $stmt = $mysqli->prepare("select * from stories");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    
    $stmt->execute();
    
    $stmt->bind_result($username, $title, $body, $link);
    
    
    while($stmt->fetch()){
    echo "<div class='story'>\n";
       echo $username;
       echo "<h3 class='storytitle'>$title</h3>";
       echo "<p class='storybody'>$body</p>";
       echo "<a href='$link' class='storylink'>$link</a>";
       echo "</div>\n";
    }
    
    
    $stmt->close();

    // $stmt = $mysqli->prepare("SELECT COUNT(*), username, title, body, link FROM stories");

    //     // Bind the results
    // $stmt->bind_result($username, $title, $body, $link);
        
    // echo $stmt;

    // $stmt->fetch();
    // $stmt->close();


?>



</body>
</html>