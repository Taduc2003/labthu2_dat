<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
          <form action="luachongv.php" method="post">
            <input type="radio" name="luachongv" value="chinhsuathongtinsvien">
            chinhsuathongtinsvien<br>
            <input type="radio" name="luachongv" value="chinhsuadiemsvien">
            chinhsuadiemsvien<br>
            <input type="radio" name="luachongv" value="nhanlaichosinhvien">
            nhanlaichosinhvien<br>
            <input type="radio" name="luachongv" value="xemphanhoi">
            xemphanhoi<br>
            <input type="radio" name="luachongv" value="xemranksvien">
            xemranksvien<br>
            <input type="radio" name="luachongv" value="tracuusinhvien">
            tracuusinhvien<br>
            <input type="submit" name="confirm" value="confirm">
            <input type="submit" name="logout" value="Log Out">
          </form>
</body>
</html>
<?php
    $luachon=$_POST["luachongv"];
        if($luachon=="chinhsuathongtinsvien"){
        header('Location: chinhsuathongtinsvien.php');
        }
        else if($luachon=="chinhsuadiemsvien"){
        session_start();
        $_SESSION['user_id'] = 1;
        header('Location: chinhsuadiemsvien.php');
        }
        else if($luachon=="nhanlaichosinhvien"){
            header('Location:nhanlaichosinhvien.php');
            }
        else if($luachon=="xemphanhoi"){
               
                header('Location:xemphanhoi.php');
                }
                else if($luachon=="xemranksvien"){
                   
                    header('Location: xemranksvien.php');
                    }
                else if($luachon=="tracuusinhvien"){
                    header('Location:tracuusinhvien.php');
                        }
                        else if (isset($_POST["logout"])) {
                            // Chuyển hướng người dùng đến trang dangnhap.php
                            header('Location: dangnhap.php');
                            exit();
                        }
?>