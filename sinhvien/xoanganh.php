<?php
session_start();

$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "dbtest1";
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Lấy student_id từ session
$student_id = $_SESSION['user_id'];

// Kiểm tra nếu đã submit form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $major_id = $_POST["major_id"];

    // Xóa ngành đã đăng ký của sinh viên
    $sql_delete_major = "DELETE FROM Major_Student WHERE student_id = '$student_id' AND major_id = '$major_id'";

    if (mysqli_query($conn, $sql_delete_major)) {
        echo "Đã xóa ngành học.";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}

// Lấy danh sách các ngành đã đăng ký của sinh viên
$sql_registered_majors = "SELECT Majors.major_id, Majors.major_name
                          FROM Majors
                          INNER JOIN Major_Student ON Majors.major_id = Major_Student.major_id
                          WHERE Major_Student.student_id = '$student_id'";
$result_registered_majors = mysqli_query($conn, $sql_registered_majors);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Xóa ngành học</title>
</head>
<body>
    <h2>Xóa ngành học</h2>
    <?php
    if (mysqli_num_rows($result_registered_majors) > 0) {
        echo "<form method='POST' action='" . $_SERVER["PHP_SELF"] . "'>";
        echo "<label for='major_id'>Ngành học:</label>";
        echo "<select name='major_id'>";

        while ($row = mysqli_fetch_assoc($result_registered_majors)) {
            echo "<option value='" . $row['major_id'] . "'>" . $row['major_name'] . "</option>";
        }

        echo "</select><br>";
        echo "<input type='submit' name='submit' value='Xóa'>";
        echo "</form>";
    } else {
        echo "Không có ngành nào được đăng ký.";
    }
    ?>

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

<?php
mysqli_close($conn);
?>
