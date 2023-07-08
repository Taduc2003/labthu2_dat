<?php

// Kết nối database
$db_server= "localhost";
$db_user="root";    
$db_pass="";
$db_name="dbtest1";
$conn="";
$conn = mysqli_connect($db_server,$db_user,$db_pass,$db_name);
// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Xử lý khi sinh viên gửi yêu cầu
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $student_id = $_POST["student_id"];
    $student_name = $_POST["student_name"];
    $request_content = $_POST["request_content"];

    // Kiểm tra nếu có dữ liệu yêu cầu
    if (!empty($request_content)) {
        // Thực hiện truy vấn INSERT để lưu yêu cầu vào cơ sở dữ liệu
        $sql = "INSERT INTO feedbacks (student_id, student_name, content)
                VALUES ('$student_id', '$student_name', '$request_content')";

        if (mysqli_query($conn, $sql)) {
            echo "Yêu cầu đã được gửi thành công.";
        } else {
            echo "Lỗi: " . mysqli_error($conn);
        }
    } else {
        echo "Vui lòng nhập nội dung yêu cầu.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gửi Yêu Cầu</title>
</head>
<body>
    <h2>Gửi Yêu Cầu</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="student_id">Mã sinh viên:</label>
        <input type="text" name="student_id" required><br>

        <label for="student_name">Tên sinh viên:</label>
        <input type="text" name="student_name" required><br>

        <label for="request_content">Nội dung yêu cầu:</label><br>
        <textarea name="request_content" rows="5" cols="40"></textarea><br>

        <input type="submit" name="submit" value="Gửi Yêu Cầu">
    </form>
</body>
</html>