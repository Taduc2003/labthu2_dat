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

// Xử lý khi giảng viên gửi yêu cầu xem xếp hạng sinh viên
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $exam_id = $_POST["exam_id"];

    // Xây dựng câu truy vấn SELECT để lấy thông tin sinh viên và điểm số theo exam_id
    $sql = "SELECT Students.student_id, Students.student_name, Results.result_score
            FROM Students
            INNER JOIN Results ON Students.student_id = Results.result_student_id
            WHERE Results.result_exam_id = '$exam_id'
            ORDER BY Results.result_score DESC";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Xếp Hạng Sinh Viên</h2>";
        echo "<table>";
        echo "<tr><th>STT</th><th>Mã Sinh Viên</th><th>Tên Sinh Viên</th><th>Điểm Số</th></tr>";

        $rank = 1;

        while ($row = mysqli_fetch_assoc($result)) {
            $student_id = $row["student_id"];
            $student_name = $row["student_name"];
            $result_score = $row["result_score"];

            echo "<tr><td>$rank</td><td>$student_id</td><td>$student_name</td><td>$result_score</td></tr>";
            $rank++;
        }

        echo "</table>";
    } else {
        echo "Không có sinh viên nào tham gia kỳ thi này.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Xếp Hạng Sinh Viên</title>
</head>
<body>
    <h2>Xếp Hạng Sinh Viên</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="exam_id">Mã môn học:</label>
        <input type="text" name="exam_id" required><br>

        <input type="submit" name="submit" value="Xem Xếp Hạng">
    </form>
</body>
</html>