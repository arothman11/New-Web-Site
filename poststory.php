<!DOCTYPE html>
<html lang="en">
<head>
    <title>Module 3 Group</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1> Upload Your Story Here! </h1>
    <form action="poststory.php" method="Post" id="uploadstory">

        <label for="title">Title:</label>
        <input type="text" name="title" id ="title">

        <label for="body">Story Text:</label>
        <textarea id="body" name="body" rows="30" cols="50"></textarea>

        <label for="link">Link:</label>
        <input type="url" name="link" id ="link">

        <button type="submit" id="logout-button">Upload Here</button>
    </form>

    <?php
         require 'database.php';
         session_start();
        
         $username = $_SESSION['user_id'];
         $title = $_POST['title'];
         $body = $_POST['body'];
         $link = $_POST['link'];

 
         $stmt = $mysqli->prepare("insert into stories (username, title, body, link) values (?, ?, ?, ?)");
         if(!$stmt){
             printf("Query Prep Failed: %s\n", $mysqli->error);
             exit;
         }
         else if (!empty($_POST)){
             echo "<p>Post successfully created.</p>";
             echo '
             <form action="main.php" method="Post">
                 <button type="submit">Return to Main Page</button>
             </form>';
         }
 
         $stmt->bind_param('ssss',  $username, $title, $body, $link);
 
         $stmt->execute();
         
         $stmt->close();
    ?>


</body>
</html>