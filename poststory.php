<!DOCTYPE html>
<html lang="en">
<head>
    <title>Module 3 Group</title>
    <link rel="stylesheet" href="stylesheet.css">
    <meta charset="UTF-8">
</head>
<body>
    <h1> Upload Your Story Here! </h1>
    <?php
        session_start();
    ?>
    <form action="poststory2.php" method="Post" id="uploadstory">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        <label for="title">Title:</label>
        <input type="text" name="title" id ="title">

        <label for="body">Story Text:</label>
        <textarea id="body" name="body" rows="30" cols="50"></textarea>

        <label for="link">Link:</label>
        <input type="url" name="link" id ="link">

        <button type="submit" id="logout-button">Upload Here</button>
    </form>

</body>
</html>

