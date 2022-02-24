<?php
header("Content-Type: text/html;charset=utf-8");
$servername = "localhost";
$database = "bd_extraescolares";
$username = "root";
$password = "";
$conn = mysqli_connect($servername, $username, $password, $database);
mysqli_set_charset( $conn, 'utf8' );
$conn->set_charset("utf8");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
?>