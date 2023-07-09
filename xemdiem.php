<?php
// Kết nối cơ sở dữ liệu
$db_server= "localhost";
$db_user="root";    
$db_pass="";
$db_name="dbtest1";
$conn="";
$conn = mysqli_connect($db_server,$db_user,$db_pass,$db_name);
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
session_start();
$user_id2 = $_SESSION['user_id'];
// Lấy thông tin sinh viên từ URL parameter
$student_id = $user_id2;

// Truy vấn cơ sở dữ liệu để lấy thông tin điểm
$sql = "SELECT students.student_id, students.student_name, results.result_score, exams.exam_name
        FROM Results
        INNER JOIN Exams ON results.result_exam_id = exams.exam_id
        INNER JOIN Students ON results.result_student_id = students.student_id
        WHERE results.result_student_id = $student_id";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Hiển thị thông tin điểm
    $isFirstRow = true; 
    while ($row = mysqli_fetch_assoc($result)) {
        if ($isFirstRow) {
            echo "Mã sinh viên: " . $row['student_id'] . "<br>";
            echo "Tên sinh viên: " . $row['student_name'] . "<br>";
            $isFirstRow = false; // Đánh dấu là đã hiển thị thông tin
        }
        
        echo "Môn: " . $row['exam_name'] . ", Điểm: " . $row['result_score'] . "<br>";
    }
} else {
    echo "Không tìm thấy thông tin điểm.";
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>trang sinh viên</title>
</head>
<body>
    <!-- Nút "Back" -->
    <button onclick="goBack()">Back</button>

    <!-- Script JavaScript -->
    <script>
        function goBack() {
            window.location.href = "luachon.php";
        }
    </script>
</body>
</html>
