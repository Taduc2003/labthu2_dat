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

    // Kiểm tra block_id từ bảng Student_Blocks
    $sql_check_block = "SELECT block_id FROM Student_Blocks WHERE student_id = '$student_id'";
    $result_check_block = mysqli_query($conn, $sql_check_block);

    $sql_count_major = "SELECT COUNT(major_id) AS count_major FROM major_student GROUP BY student_id = '$student_id'";
    $result_count_major = mysqli_query($conn, $sql_count_major);
    $row_count_major = mysqli_fetch_assoc($result_count_major);
    $count_major = $row_count_major['count_major'];


    if (mysqli_num_rows($result_check_block) > 0) {
        $row = mysqli_fetch_assoc($result_check_block);
        $block_id = $row["block_id"];
    
        // Kiểm tra block_id và major_id trong bảng Cutoff_Scores
        $sql_check_cutoff = "SELECT * FROM Cutoff_Scores WHERE major_id = '$major_id' AND block_id = '$block_id'";
        $result_check_cutoff = mysqli_query($conn, $sql_check_cutoff);

        if (mysqli_num_rows($result_check_cutoff) > 0) {
            // Thực hiện đăng ký ngành học
            if ($count_major < 5) {
                // Tiếp tục đăng ký ngành
                $sql_register_major = "INSERT IGNORE INTO Major_Student (student_id, major_id) VALUES ('$student_id', '$major_id')";
            
            if (mysqli_query($conn, $sql_register_major)) {
                if (mysqli_affected_rows($conn) > 0) {
                    echo "Đăng ký ngành học thành công.";
                } else {
                    echo "Ngành học đã được đăng ký trước đó.";
                }
            } else {
                echo "Lỗi: " . mysqli_error($conn);
            }
        } else {
            echo "Bạn đã đăng ký tối đa 5 ngành.";
        }
        } else {
            echo "Không thể đăng ký ngành học. Vui lòng đăng ký khối tương ứng trước đó.";
        }
    } else {
        echo "Không thể đăng ký ngành học. Vui lòng đăng ký khối trước đó.";
    }
}

// Lấy danh sách ngành học tương ứng với các khối đã đăng ký
$sql_majors = "SELECT Majors.major_id, Majors.major_name 
               FROM Majors 
               INNER JOIN Cutoff_Scores ON Majors.major_id = Cutoff_Scores.major_id 
               INNER JOIN Student_Blocks ON Cutoff_Scores.block_id = Student_Blocks.block_id 
               WHERE Student_Blocks.student_id = '$student_id'";

$result_majors = mysqli_query($conn, $sql_majors);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký ngành học</title>
</head>
<body>
    <h2>Đăng ký ngành học</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="major_id">Mã ngành:</label>
        <select name="major_id">
            <?php
            while ($row = mysqli_fetch_assoc($result_majors)) {
                echo "<option value='" . $row['major_id'] . "'>" . $row['major_name'] . "</option>";
            }
            mysqli_close($conn);
            
            ?>
        </select><br>

        <input type="submit" name="submit" value="Đăng ký">

    </form>
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


