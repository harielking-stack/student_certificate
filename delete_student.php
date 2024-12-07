<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // First, delete the student’s photo and certificate from the server
    $result = $conn->query("SELECT * FROM students WHERE id = $id");
    $student = $result->fetch_assoc();

    if ($student) {
        unlink("uploads/" . $student['photo']);
        unlink("uploads/" . $student['certificate']);
    }

    // Then, delete the student record from the database
    $query = "DELETE FROM students WHERE id = $id";
    if ($conn->query($query)) {
        echo "Student deleted successfully!";
        header("Location: view_student.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
