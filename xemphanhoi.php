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

// Xử lý khi giảng viên đánh dấu phản hồi đã hoàn thành
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mark_completed"])) {
    $feedback_id = $_POST["feedback_id"];

    // Thực hiện truy vấn UPDATE để đánh dấu phản hồi đã hoàn thành
    $sql = "UPDATE feedbacks SET completed = 1 WHERE id = $feedback_id";
    if (mysqli_query($conn, $sql)) {
        echo "Phản hồi đã được đánh dấu hoàn thành.";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}

// Truy vấn để lấy danh sách feedbacks
$sql = "SELECT * FROM feedbacks";
$result = mysqli_query($conn, $sql);

// Kiểm tra kết quả truy vấn
if (mysqli_num_rows($result) > 0) {
    echo "<h2>Danh sách phản hồi từ sinh viên:</h2>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<p><strong>Mã sinh viên:</strong> " . $row["student_id"] . "</p>";
        echo "<p><strong>Tên sinh viên:</strong> " . $row["student_name"] . "</p>";
        echo "<p><strong>Nội dung phản hồi:</strong> " . $row["content"] . "</p>";
        
        // Kiểm tra trạng thái của phản hồi
        if ($row["completed"] == 1) {
            echo "<p>Trạng thái: Hoàn thành</p>";
        } else {
            echo "<p>Trạng thái: Chưa hoàn thành</p>";
            // Hiển thị nút đánh dấu đã hoàn thành
            echo "<form method='POST' action='".$_SERVER["PHP_SELF"]."'>";
            echo "<input type='hidden' name='feedback_id' value='".$row["id"]."'>";
            echo "<input type='submit' name='mark_completed' value='Đánh dấu đã hoàn thành'>";
            echo "</form>";
        }
        
        echo "<hr>";
    }
} else {
    echo "Không có phản hồi từ sinh viên.";
}

mysqli_close($conn);
?>
