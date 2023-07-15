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

// Xử lý khi giảng viên gửi yêu cầu xem xếp hạng sinh viên theo khối
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $block_id = $_POST["block_id"];

    // Xây dựng câu truy vấn SELECT để lấy thông tin sinh viên và tổng điểm các môn trong khối
    $sql = "SELECT Students.student_id, Students.student_name, SUM(Results.result_score) AS total_score
            FROM Students
            INNER JOIN Results ON Students.student_id = Results.result_student_id
            INNER JOIN Exam_Block ON Results.result_exam_id = Exam_Block.exam_id
            WHERE Exam_Block.block_id = '$block_id'
            GROUP BY Students.student_id
            ORDER BY total_score DESC";

    $result = mysqli_query($conn, $sql);
    $sql_block_name = "SELECT block_name FROM BLocks WHERE block_id = '$block_id' ";
    $result1 = mysqli_query($conn, $sql_block_name);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result1)) {
            $block_name = $row["exam_name"];
            echo "<h2>Xếp Hạng Theo $block_name </h2>"; 
        }
        echo "<table>";
        echo "<tr><th>STT</th><th>Mã Sinh Viên</th><th>Tên Sinh Viên</th><th>Tổng Điểm</th></tr>";

        $rank = 1;

        while ($row = mysqli_fetch_assoc($result)) {
            $student_id = $row["student_id"];
            $student_name = $row["student_name"];
            $total_score = $row["total_score"];
            $total_score_formatted = number_format($total_score, 2);
            echo "<tr><td>$rank</td><td>$student_id</td><td>$student_name</td><td>$total_score_formatted</td></tr>";
            $rank++;
        }

        echo "</table>";
    } else {
        echo "Không có sinh viên trong khối này.";
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Xếp Hạng Sinh Viên Theo Khối</title>
</head>
<body>
    <h2>Xếp Hạng Sinh Viên Theo Khối</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="block_id">Mã khối:</label>
        <input type="text" name="block_id" required><br>

        <input type="submit" name="submit" value="Xem Xếp Hạng">

        <!-- Nút "Back" -->
        <button onclick="goBack()">Back</button>

        <!-- Script JavaScript -->
        <script>
            function goBack() {
                window.location.href = "luachongv.php";
            }
        </script>
    </form>
</body>
</html>