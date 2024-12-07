<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get student_id and student name from POST data
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];

    // Construct the query to search either by student_id or name
    if (!empty($student_id)) {
        $result = $conn->query("SELECT * FROM students WHERE student_id='$student_id'");
    } elseif (!empty($name)) {
        $result = $conn->query("SELECT * FROM students WHERE name LIKE '%$name%'");
    }

    if ($result && $result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        $error = "No student found with the provided details.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Search</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #34495e, #2c3e50);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }
        header {
            width: 100%;
            padding: 15px 20px;
            background-color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header img {
            width: 180px;
            padding: 15px 20px;
            margin-left: 20px;
        }
        .back-link {
            color: #fff;
            background-color: #3498db;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 4px;
            transition: background 0.3s;
            margin-right: 20px;
        }
        .back-link:hover {
            background-color: #2980b9;
        }
        .search-container {
            background: #ffffff;
            color: #333;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 90%;
            max-width: 900px;
            margin-top: 20px;
        }
        .search-container h2 {
            margin-bottom: 20px;
            font-size: 1.8rem;
            color: #34495e;
        }
        .search-container form {
            margin-bottom: 20px;
        }
        .search-container input {
            width: calc(50% - 20px);
            padding: 10px;
            margin: 10px 10px 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            display: inline-block;
        }
        .search-container button {
            padding: 10px 20px;
            background: #34495e;
            color: #fff;
            font-size: 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .search-container button:hover {
            background: #2c3e50;
        }
        .student-details {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }
        .student-details th, .student-details td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .student-details th {
            background-color: #f4f4f4;
            color: #333;
        }
        .student-details img {
            display: block;
            margin: 0 auto;
            max-width: 250px;
            height: auto;
            align: left;
        }
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                text-align: center;
            }
            header img {
                width: 60px;
            }
            .back-link {
                margin-top: 10px;
                font-size: 0.9rem;
            }
            .search-container h2 {
                font-size: 1.5rem;
            }
            .search-container input, .search-container button {
                font-size: 0.9rem;
            }
            .student-details th, .student-details td {
                font-size: 0.9rem;
            }
        }
        @media (max-width: 480px) {
            .search-container {
                padding: 15px;
            }
            .search-container h2 {
                font-size: 1.2rem;
            }
            .student-details th, .student-details td {
                font-size: 0.8rem;
                padding: 5px;
            }
            .student-details img {
                max-width: 120px;
            }
        }
    </style>
</head>
<body>
    <header>
        <a href="https://alfrin.in"><img src="ALFRIN-Logo-New-with-success.png" alt="Alfrin Logo"></a>
        <a href="https://alfrin.in" class="back-link">Back to Alfrin Website</a>
    </header>

    <div class="search-container">
        <h2>Student Search</h2>
        <form method="POST">
            <input type="text" name="student_id" placeholder="Enter Student ID"><br>OR<br>
            <input type="text" name="name" placeholder="Enter Student Name"><br>
            <button type="submit">Search</button>
        </form>

        <?php if (isset($student)): ?>
            <h3>Student Details</h3>
            <table class="student-details">
                <tr>
                    <th>Name</th>
                    <td><?= htmlspecialchars($student['name']) ?></td>
                </tr>
                <tr>
                    <th>Course</th>
                    <td><?= htmlspecialchars($student['course']) ?></td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td><?= htmlspecialchars($student['phone']) ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= htmlspecialchars($student['email']) ?></td>
                </tr>
                <tr>
                    <th>Photo</th>
                    <td>
                        <img src="uploads/<?= htmlspecialchars($student['photo']) ?>" alt="Photo"><br>
                    </td>
                </tr>
                <tr>
                    <th>Certificate</th>
                    <td>
                        <img src="uploads/<?= htmlspecialchars($student['certificate']) ?>" alt="Certificate"><br>
                    </td>
                </tr>
            </table>
        <?php elseif (isset($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
