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

// Xử lý khi giảng viên gửi lại lời nhắn
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $student_id = $_POST["student_id"];
    $message = $_POST["message"];

    // Kiểm tra nếu có dữ liệu lời nhắn
    if (!empty($message)) {
        // Thực hiện truy vấn UPDATE để cập nhật lời nhắn cho sinh viên tương ứng
        $sql = "UPDATE Students SET message = '$message' WHERE student_id = '$student_id'";

        if (mysqli_query($conn, $sql)) {
            echo "Lời nhắn đã được gửi lại thành công.";
        } else {
            echo "Lỗi: " . mysqli_error($conn);
        }
    } else {
        echo "Vui lòng nhập nội dung lời nhắn.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gửi lại lời nhắn</title>
</head>
<body>
    <h2>Gửi lại lời nhắn</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="student_id">Mã sinh viên:</label>
        <input type="text" name="student_id" required><br>

        <label for="message">Nội dung lời nhắn:</label><br>
        <textarea name="message" rows="5" cols="40"></textarea><br>

        <input type="submit" name="submit" value="Gửi lại lời nhắn">
    </form>
</body>
</html>