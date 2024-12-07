<?php
session_start();
include 'config.php';
include 'header.php';



$notification = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $course = $_POST['course'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $photo = $_FILES['photo']['name'];
    $certificate = $_FILES['certificate']['name'];

    // Check for duplicates
    $checkQuery = "SELECT * FROM students 
                   WHERE student_id = '$student_id' 
                   OR phone = '$phone' 
                   OR email = '$email' 
                   OR name = '$name'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        $notification = "Error: A student with the same details already exists.";
    } else {
        // Proceed with insertion if no duplicates
        if ($photo) {
            move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/" . $photo);
        }

        if ($certificate) {
            move_uploaded_file($_FILES['certificate']['tmp_name'], "uploads/" . $certificate);
        }

        $query = "INSERT INTO students (student_id, name, course, phone, email, photo, certificate)
                  VALUES ('$student_id', '$name', '$course', '$phone', '$email', '$photo', '$certificate')";

        if ($conn->query($query)) {
            $notification = "Student added successfully!";
        } else {
            $notification = "Error: " . $conn->error;
        }
    }
}

// Fetch student details after submission
$uploadedStudent = null;
if (!empty($student_id)) {
    $result = $conn->query("SELECT * FROM students WHERE student_id = '$student_id'");
    $uploadedStudent = $result->fetch_assoc();
}
?>

<form method="POST" enctype="multipart/form-data">
    <h2>Add Student</h2>

    <?php if ($notification): ?>
        <p style="color: red;"><?php echo $notification; ?></p>
    <?php endif; ?>

    <input type="text" name="student_id" placeholder="Student ID" required><br>
    <input type="text" name="name" placeholder="Name" required><br>
    <input type="text" name="course" placeholder="Course" required><br>
    <input type="text" name="phone" placeholder="Phone" required><br>
    <input type="email" name="email" placeholder="Email" required><br>

    <label for="photo">Upload Photo:</label>
    <input type="file" name="photo" <?php echo $uploadedStudent ? '' : 'required'; ?>><br>
    
    <?php if ($uploadedStudent && $uploadedStudent['photo']): ?>
        <img src="uploads/<?php echo $uploadedStudent['photo']; ?>" alt="Uploaded Photo" style="width:100px;height:auto;"><br>
    <?php endif; ?>

    <label for="certificate">Upload Certificate:</label>
    <input type="file" name="certificate" <?php echo $uploadedStudent ? '' : 'required'; ?>><br>
    
    <?php if ($uploadedStudent && $uploadedStudent['certificate']): ?>
        <a href="uploads/<?php echo $uploadedStudent['certificate']; ?>" target="_blank">View Certificate</a><br>
    <?php endif; ?>

    <button type="submit">Save</button>
    <button type="reset" onclick="location.reload()">Reset</button>
</form>
