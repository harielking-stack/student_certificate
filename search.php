<?php
session_start();
include 'config.php';
include 'header.php'; // Include header for admin menu



// Handle search query
$search_results = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get search terms for multiple fields
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Build the query dynamically based on which fields are filled
    $query = "SELECT * FROM students WHERE 1"; // Always true condition to allow appending conditions

    if (!empty($name)) {
        $query .= " AND name LIKE '%$name%'";
    }
    if (!empty($student_id)) {
        $query .= " AND student_id LIKE '%$student_id%'";
    }
    if (!empty($phone)) {
        $query .= " AND phone LIKE '%$phone%'";
    }
    if (!empty($email)) {
        $query .= " AND email LIKE '%$email%'";
    }

    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $search_results[] = $row;
    }
}
?>

<div class="container">
    <h2 align="center">Search Students</h2>
    <form method="POST">
        <!-- Input fields for multiple search criteria -->
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter student name"><br><br>

        <label for="student_id">Student ID:</label>
        <input type="text" id="student_id" name="student_id" placeholder="Enter student ID"><br><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" placeholder="Enter phone number"><br><br>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" placeholder="Enter email"><br><br>

        <button type="submit">Search</button>
    </form>

    <?php if (!empty($search_results)): ?>
        <h3 align="center">Search Results</h3>
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Photo</th>
                    <th>Certificate</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($search_results as $student): ?>
                    <tr>
                        <td><?= $student['student_id'] ?></td>
                        <td><?= $student['name'] ?></td>
                        <td><?= $student['course'] ?></td>
                        <td><?= $student['phone'] ?></td>
                        <td><?= $student['email'] ?></td>
                        <td>
                            <!-- Display student photo if available -->
                            <?php if ($student['photo']): ?>
                                <img src="uploads/<?= $student['photo'] ?>" alt="Photo" width="100">
                            <?php else: ?>
                                No photo available
                            <?php endif; ?>
                        </td>
                        <td>
                            <!-- Display certificate link if available -->
                            <?php if ($student['certificate']): ?>
                                <a href="uploads/<?= $student['certificate'] ?>" target="_blank">View Certificate</a>
                            <?php else: ?>
                                No certificate available
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit_student.php?id=<?= $student['id'] ?>">Edit</a>
                            <a href="view_student.php?delete=<?= $student['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p>No students found for the specified criteria.</p>
    <?php endif; ?>
</div>

<?php
// Footer to close HTML tags if required
?>
