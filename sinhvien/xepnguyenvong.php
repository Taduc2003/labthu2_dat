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

// Lấy danh sách nguyện vọng ngành học của sinh viên
$sql_majors = "SELECT Major_Student.major_id, Majors.major_name, Major_Student.major_level
               FROM Major_Student
               INNER JOIN Majors ON Major_Student.major_id = Majors.major_id
               WHERE Major_Student.student_id = '$student_id'
               ORDER BY Major_Student.major_level ASC";

$result_majors = mysqli_query($conn, $sql_majors);

// Kiểm tra nếu đã submit form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Lấy danh sách thứ tự ưu tiên mới từ form
    $major_level = $_POST["major_level"];
    
    // Chuyển đổi mảng thứ tự ưu tiên thành mảng không trùng lặp và sắp xếp từ 1 trở đi
    $uniquemajor_level = array_unique($major_level);
    sort($uniquemajor_level);
    
    // Kiểm tra số lượng nguyện vọng có khớp với số lượng thứ tự ưu tiên
    $numMajors = mysqli_num_rows($result_majors);
    $numUniquemajor_level = count($uniquemajor_level);
    
    if ($numMajors != $numUniquemajor_level) {
        echo "Số lượng thứ tự ưu tiên không khớp với số lượng nguyện vọng.";
    } else {
        // Duyệt qua danh sách nguyện vọng và cập nhật thứ tự ưu tiên trong bảng Major_Student
        foreach ($major_level as $index => $major_level) {
            $major_id = $_POST["major_id"][$index];
            $newmajor_level = $uniquemajor_level[$index];
            
            // Cập nhật thứ tự ưu tiên mới
            $sql_update_major_level= "UPDATE Major_Student SET major_level = '$newmajor_level' WHERE student_id = '$student_id' AND major_id = '$major_id'";
            mysqli_query($conn, $sql_update_major_level);
        }
        
        echo "Cập nhật thứ tự ưu tiên thành công.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thứ tự ưu tiên nguyện vọng</title>
</head>
<body>
    <h2>Thứ tự ưu tiên nguyện vọng</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <?php
        $major_levelCount = 1;
        
        while ($row = mysqli_fetch_assoc($result_majors)) {
            echo "<label for='priority[]'>" . $row['major_name'] . ":</label>";
            echo "<input type='hidden' name='major_id[]' value='" . $row['major_id'] . "'>";
            echo "<input type='number' name='major_level[]' value='" . $major_levelCount . "' min='1' required max='5'><br>";
            
            $major_levelCount++;
        }
        ?>

        <input type="submit" name="submit" value="Cập nhật">

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
