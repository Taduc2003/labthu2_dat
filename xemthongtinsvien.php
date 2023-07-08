<?php
$db_server= "localhost";
$db_user="root";    
$db_pass="";
$db_name="dbtest1";
$conn="";
$conn = mysqli_connect($db_server,$db_user,$db_pass,$db_name);
session_start();
$user_id = $_SESSION['user_id'];
$student_id = $user_id; // student_id cần tìm
$sql = "SELECT * FROM Students WHERE student_id = '$student_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Lặp qua từng hàng kết quả
    while ($row = mysqli_fetch_assoc($result)) {
        // In thông tin sinh viên
        echo "Student ID: " . $row['student_id'] . "<br>";
        echo "Student Name: " . $row['student_name'] . "<br>";
        echo "Student Email: " . $row['student_email'] . "<br>";
        echo "Student Date of Birth: " . $row['student_date_of_birth'] . "<br>";
        echo "Student Gender: " . $row['student_gender'] . "<br>";
        echo "Student Address: " . $row['student_address'] . "<br>";
        echo "Student Password: " . $row['student_password'] . "<br>";
    }
} else {
    echo "No student found with the provided student ID.";
}



?>