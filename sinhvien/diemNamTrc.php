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
$sql = "SELECT m.major_name, b.block_name, c.cutoff_score FROM Majors m 
        JOIN Cutoff_Scores c ON c.major_id = m.major_id
        JOIN Blocks b ON c.block_id = b.block_id
        ORDER BY major_name DESC";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Hiển thị thông tin điểm
    echo "<table>";
    echo "<tr><th>Major</th><th>Block</th><th>Cutoff Score</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["major_name"]."</td>";
        echo "<td>".$row["block_name"]."</td>";
        echo "<td>".$row["cutoff_score"]."</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No records found";
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
