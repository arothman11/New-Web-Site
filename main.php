<!DOCTYPE html>
<html lang="en">
<head>
    <title>Module 3 Group</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="login">
    <h1>Log In</h1>
    <p>Please enter your username in the text field below.</p>
    <form action="main.php" method="Get">
        <label for="username">Username</label>
        <input type="text" name="username" id="username">
        <input type="submit">
   </form>
   </div>
    <form action="newUser.php">
        <label for="new">Don't have a username?</label>
        <button name="new" id="new">Create New Account</button>
    </form>
<?php
?>

</body>
</html>