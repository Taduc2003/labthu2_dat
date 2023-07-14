<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
          <form action="luachon.php" method="post">
            <input type="radio" name="luachonsvien" value="xemthongtin">
            xemthongtin<br>
            <input type="radio" name="luachonsvien" value="xemdiem">
            xemdiem<br>
            <input type="radio" name="luachonsvien" value="diemchuannamtrc">
            diemchuannamtrc<br>
            <input type="radio" name="luachonsvien" value="guiyeucau">
            guiyeucau<br>
            <input type="radio" name="luachonsvien" value="phanhoicuagiangvien">
            phanhoicuagiangvien<br>
            <input type="submit" name="confirm" value="confirm">
            <input type="submit" name="logout" value="Log Out">
          </form>
</body>
</html>
<?php
    session_start();
    $user_id1 = $_SESSION['user_id'];
    $luachon=$_POST["luachonsvien"];
    if($luachon=="xemthongtin"){
    session_start();
    $_SESSION['user_id'] = $user_id1;
    header('Location: xemthongtinsvien.php');
    }
    else if($luachon=="xemdiem"){
        session_start();
        $_SESSION['user_id'] = $user_id1;
        header('Location: xemdiem.php');
        }
        else if($luachon=="guiyeucau"){
            session_start();
            $_SESSION['user_id'] = $user_id1;
            header('Location: guiyeucau.php');
            }
            else if($luachon=="phanhoicuagiangvien"){
                session_start();
                $_SESSION['user_id'] = $user_id1;
                header('Location:phanhoicuagiangvien.php');
                }
                else if($luachon=="diemchuannamtrc"){
                    session_start();
                    $_SESSION['user_id'] = $user_id1;
                    header('Location:diemNamtrc.php');
                    }
                    if (isset($_POST["logout"])) {
                        // Xóa tất cả các session
                        session_unset();
                        session_destroy();
                    
                        // Chuyển hướng người dùng đến trang dangnhap.php
                        header('Location: dangnhap.php');
                        if (isset($_POST["logout"])) {
                            // Xóa tất cả các session
                            session_unset();
                            session_destroy();
                        
                            // Chuyển hướng người dùng đến trang dangnhap.php
                            header('Location: dangnhap.php');
                            exit();
                        }
                    }
                        
    
?>