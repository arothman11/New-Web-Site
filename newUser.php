<!DOCTYPE html>
<html lang="en">
<head>
    <title>Module 2 Group</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="newUser.php" method="Post">
        <label for="newUsername">Username</label>
        <input type="text" name="newUsername" id="newUsername">

        <label for="newPassword">Password</label>
        <input type="password" name="newPassword" id="newPassword">
        <input type="submit">
    </form>

    <?php
        require 'database.php';

        $newUsername = $_POST['newUsername'];
        if (!empty($_POST)) {
            if( !preg_match('/^[\w_\-]+$/', $newUsername) ){
                echo "<p>Invalid username</p>";
                exit;
            }
        }
        $newPassword = $_POST['newPassword'];
        if (!empty($_POST)) {
            if( !preg_match('/^[\w_\-]+$/', $newPassword) ){
                echo "<p>Invalid password</p>";
                exit;
            }
        }

        $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT);
        
        $stmt = $mysqli->prepare("insert into users (username, hashed_password) values (?, ?)");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        else if (!empty($_POST)){
            echo "<p>User successfully created.</p>";
            echo '
            <form action="login.php" method="Post">
                <button type="submit">Return Home</button>
            </form>';
        }

        $stmt->bind_param('ss',  $newUsername, $passwordHash);

        
        $stmt->execute();
        
        $stmt->close();
    ?>
</body>
</html>