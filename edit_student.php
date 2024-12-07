<?php
include 'config.php';
include 'header.php';

// Check if the user is authenticated
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    // Redirect to index.php if not authenticated
    header("Location: index.php");
    exit();
}
?>


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM students WHERE id = $id");
    $student = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $course = $_POST['course'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $photo = $_FILES['photo']['name'] ? $_FILES['photo']['name'] : $student['photo'];
    $certificate = $_FILES['certificate']['name'] ? $_FILES['certificate']['name'] : $student['certificate'];

    // Upload new photo and certificate if provided
    if ($_FILES['photo']['name']) {
        move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/" . $photo);
    }
    if ($_FILES['certificate']['name']) {
        move_uploaded_file($_FILES['certificate']['tmp_name'], "uploads/" . $certificate);
    }

    $query = "UPDATE students SET 
                student_id='$student_id', 
                name='$name', 
                course='$course', 
                phone='$phone', 
                email='$email', 
                photo='$photo', 
                certificate='$certificate'
              WHERE id=$id";

    if ($conn->query($query)) {
        echo "Student updated successfully!";
        header("Location: view_student.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<form method="POST" enctype="multipart/form-data">
    <h2>Edit Student</h2>
    <input type="text" name="student_id" placeholder="Student ID" value="<?= $student['student_id'] ?>" required><br>
    <input type="text" name="name" placeholder="Name" value="<?= $student['name'] ?>" required><br>
    <input type="text" name="course" placeholder="Course" value="<?= $student['course'] ?>" required><br>
    <input type="text" name="phone" placeholder="Phone" value="<?= $student['phone'] ?>"><br>
    <input type="email" name="email" placeholder="Email" value="<?= $student['email'] ?>"><br>
    <input type="file" name="photo"><br>
    <input type="file" name="certificate"><br>
    <button type="submit">Update Student</button>
</form>
