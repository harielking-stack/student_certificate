<?php
session_start();
include 'config.php';
include 'header.php';


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM students WHERE id=$id");
    header("Location: view_student.php");
}

$result = $conn->query("SELECT * FROM students");
?>

<h2 align="center">View Students</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Student ID</th>
        <th>Name</th>
        <th>Course</th>
        <th>Photo</th>
        <th>Certificate</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['student_id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['course'] ?></td>
            <td>
                <!-- Display student photo if available -->
                <?php if ($row['photo']): ?>
                    <img src="uploads/<?= $row['photo'] ?>" alt="Photo" width="100">
                <?php else: ?>
                    No photo available
                <?php endif; ?>
            </td>
            <td>
                <!-- Display certificate link if available -->
                <?php if ($row['certificate']): ?>
                    <a href="uploads/<?= $row['certificate'] ?>" target="_blank">View Certificate</a>
                <?php else: ?>
                    No certificate available
                <?php endif; ?>
            </td>
            <td>
                <a href="edit_student.php?id=<?= $row['id'] ?>">Edit</a>
                <a href="view_student.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
