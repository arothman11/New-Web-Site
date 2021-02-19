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
    <form action="login.php" method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" id="username">

        <label for="password">Password</label>
        <input type="password" name="password" id="password">

        <input type="submit">
   </form>
   </div>
    <form action="newUser.php">
        <label for="new">Don't have an account?</label>
        <button name="new" id="new">Create New Account</button>
    </form>

    <?php

        require 'database.php';
        session_start();

        // Use a prepared statement
        $stmt = $mysqli->prepare("SELECT COUNT(*), username, hashed_password FROM users WHERE username=?");

        // Bind the parameter
        $stmt->bind_param('s', $user);
        $user = $_POST['username'];
        $stmt->execute();

        // Bind the results
        $stmt->bind_result($cnt, $user_id, $pwd_hash);
        
        $stmt->fetch();

        $pwd_guess = $_POST['password'];
        // Compare the submitted password to the actual password hash

        if($cnt == 1 && password_verify($pwd_guess, $pwd_hash)){
            // Login succeeded!
            $_SESSION['user_id'] = $user_id;
            header("Location: main.php");
            // Redirect to your target page
        } else if (!empty($_POST)){
            echo '<p>Login Failed</p>';
            // Login failed; redirect back to the login screen
        }
?>

</body>
</html>