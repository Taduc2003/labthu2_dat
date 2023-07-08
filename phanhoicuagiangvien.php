<?php

// Kết nối database
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "dbtest1";

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

session_start();
$user_id3 = $_SESSION['user_id'];

// Lấy lời nhắn cho sinh viên dựa trên user_id
$sql = "SELECT message FROM Students WHERE student_id = '$user_id3'";
$result = mysqli_query($conn, $sql);

// Kiểm tra kết quả và hiển thị lời nhắn
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $message = $row["message"];
    echo "Lời nhắn từ giảng viên:<br>";
    echo $message;
} else {
    echo "Không có lời nhắn.";
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
</body>
</html>
