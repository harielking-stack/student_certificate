<?php
$servername = "localhost";
$username = "alfrinin_alfrinco";
$password = "Dumas@2000";
$dbname = "alfrinin_student_manage";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
