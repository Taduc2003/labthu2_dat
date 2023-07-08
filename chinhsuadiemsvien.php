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

// Xử lý khi giảng viên thực hiện chỉnh sửa điểm
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $student_id = $_POST["student_id5"];
    $exam_id = $_POST["exam_id5"];
    $new_score = $_POST["new_score5"];

    // Thực hiện truy vấn UPDATE để cập nhật điểm của sinh viên
    $sql = "UPDATE results
            SET result_score = '$new_score'
            WHERE result_student_id = '$student_id' AND result_exam_id = '$exam_id'";

    if (mysqli_query($conn, $sql)) {
        echo "Điểm của sinh viên đã được cập nhật thành công.";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chỉnh Sửa Điểm Sinh Viên</title>
</head>
<body>
    <h2>Chỉnh Sửa Điểm Sinh Viên</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="student_id5">Mã sinh viên:</label>
        <input type="text" name="student_id5" required><br>

        <label for="exam_id5">Mã bài thi:</label>
        <input type="text" name="exam_id5" required><br>

        <label for="new_score5">Điểm mới:</label>
        <input type="text" name="new_score5" required><br>

        <input type="submit" name="submit" value="Cập Nhật Điểm">
    </form>
</body>
</html>
