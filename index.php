<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
          <form action="index.php" method="post">
            student_id:<br>
            <input type="text" name="username"><br>
            password:<br>
            <input type="text" name="password"><br>
            <input type="submit" name="login" value ="login">
          </form>
</body>
</html>
<?php
    $db_server= "localhost";
    $db_user="root";    
    $db_pass="";
    $db_name="dbtest1";
    $conn="";
    $conn = mysqli_connect($db_server,$db_user,$db_pass,$db_name);
           $username=$_POST["username"];
           $password=$_POST["password"];
           $sql = "SELECT * FROM Students WHERE student_id = '$username' AND student_password = '$password'";
           $result = mysqli_query($conn, $sql);
           // Kiểm tra kết quả
           if (mysqli_num_rows($result) > 0) {
            session_start();
            $_SESSION['user_id'] = 1;
            header('Location: minhdat.php');
           } else {
               echo "out";
           }
           
?>