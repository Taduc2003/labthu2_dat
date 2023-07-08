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

// Xử lý khi giảng viên gửi yêu cầu sửa đổi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $student_id = $_POST["student_id"];
    $student_name = $_POST["student_name"];
    $student_email = $_POST["student_email"];
    $student_gender = $_POST["student_gender"];
    $student_date_of_birth = $_POST["student_date_of_birth"];
    $student_address = $_POST["student_address"];

    // Kiểm tra nếu có dữ liệu nhập vào
    if (!empty($student_gender)||!empty($student_name) || !empty($student_email) || !empty($student_date_of_birth) || !empty($student_address)) {
        // Xây dựng câu truy vấn UPDATE
        $sql = "UPDATE Students SET ";

        // Kiểm tra và thêm vào câu truy vấn các thông tin được cập nhật
        if (!empty($student_name)) {
            $sql .= "student_name = '$student_name', ";
        }
        if (!empty($student_gender)) {
            $sql .= "student_gender = '$student_gender', ";
        }

        if (!empty($student_email)) {
            $sql .= "student_email = '$student_email', ";
        }

        if (!empty($student_date_of_birth)) {
            $sql .= "student_date_of_birth = '$student_date_of_birth', ";
        }

        if (!empty($student_address)) {
            $sql .= "student_address = '$student_address', ";
        }

        // Loại bỏ dấu phẩy cuối cùng
        $sql = rtrim($sql, ", ");

        // Thêm điều kiện WHERE để chỉnh sửa sinh viên dựa trên student_id
        $sql .= "WHERE student_id = '$student_id'";

        // Thực thi truy vấn UPDATE để cập nhật thông tin sinh viên
        if (mysqli_query($conn, $sql)) {
            echo "Thông tin sinh viên đã được cập nhật thành công.";
        } else {
            echo "Lỗi: " . mysqli_error($conn);
        }
    } else {
        echo "Vui lòng nhập ít nhất một thông tin để cập nhật.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sửa Đổi Thông Tin Sinh Viên</title>
</head>
<body>
    <h2>Sửa Đổi Thông Tin Sinh Viên</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="student_id">Mã sinh viên:</label>
        <input type="text" name="student_id" required><br>

        <label for="student_name">Tên sinh viên:</label>
        <input type="text" name="student_name"><br>

        <label for="student_email">Email sinh viên:</label>
        <input type="email" name="student_email"><br>
        <label for="student_gender">Giới tính của sinh viên:</label>
        <input type="gender" name="student_gender"><br>

        <label for="student_date_of_birth">Ngày sinh:</label>
        <input type="date" name="student_date_of_birth"><br>

        <label for="student_address">Địa chỉ:</label>
        <input type="text" name="student_address"><br>

        <input type="submit" name="submit" value="Lưu Thay Đổi">
    </form>
</body>
</html>