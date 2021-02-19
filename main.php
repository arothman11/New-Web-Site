<!DOCTYPE html>
<html lang="en">
<head>
    <title>Module 3 Group</title>
    <link rel="stylesheet" href="style.css">
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
    
?>



</body>
</html>