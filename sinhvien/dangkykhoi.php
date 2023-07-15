<?php
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
$student_id = $_SESSION['user_id']; // Lấy student_id từ session của sinh viên

// Xử lý khi sinh viên đăng ký khối
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $block_id = $_POST["block_id"];

    // Kiểm tra xem sinh viên đã đăng ký khối này chưa
    $sql_check = "SELECT * FROM Student_Blocks WHERE student_id = '$student_id' AND block_id = '$block_id'";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        echo "Bạn đã đăng ký khối này rồi.";
    } else {
        // Thực hiện đăng ký khối cho sinh viên
        $sql_register = "INSERT INTO Student_Blocks (student_id, block_id) VALUES ('$student_id', '$block_id')";
        
        if (mysqli_query($conn, $sql_register)) {
            echo "Đăng ký khối thành công.";
        } else {
            echo "Lỗi: " . mysqli_error($conn);
        }
    }
}

// Lấy danh sách khối để sinh viên đăng ký
$sql_blocks = "SELECT * FROM Blocks";
$result_blocks = mysqli_query($conn, $sql_blocks);

if (mysqli_num_rows($result_blocks) > 0) {
    echo "<h2>Đăng ký khối</h2>";
    echo "<form method='POST' action='" . $_SERVER['PHP_SELF'] . "'>";
    echo "<label for='block_id'>Chọn khối:</label>";
    echo "<select name='block_id'>";
    
    while ($row = mysqli_fetch_assoc($result_blocks)) {
        $block_id = $row['block_id'];
        $block_name = $row['block_name'];
        echo "<option value='$block_id'>$block_name</option>";
    }
    
    echo "</select>";
    echo "<input type='submit' name='register' value='Đăng Ký'>";
    echo "</form>";
} else {
    echo "Hiện không có khối nào để đăng ký.";
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gửi Yêu Cầu</title>
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
