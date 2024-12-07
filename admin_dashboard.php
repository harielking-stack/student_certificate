<?php
session_start();
include 'config.php';
include 'header.php'; // Include the header for navigation



// Query to count the total number of students
$result = $conn->query("SELECT COUNT(*) as total_students FROM students");
$data = $result->fetch_assoc();
$total_students = $data['total_students']; // Total students count
?>

<!-- Dashboard container -->
<div class="container">
    <h2 class="dashboard-title">Admin Dashboard</h2>
    <div class="dashboard-summary">
        <div class="summary-card">
            <h3>Total Students</h3>
            <p><?= $total_students ?></p>
        </div>
    </div>
</div>

<!-- Footer or closing tags, if needed -->
<?php
// Footer to close the HTML structure
?>

<!-- CSS to style the dashboard -->
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        text-align: center; /* Center the content inside the container */
    }

    .dashboard-title {
        font-size: 36px;
        color: #333;
        margin-bottom: 30px;
    }

    .dashboard-summary {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 30px;
        flex-wrap: wrap; /* Ensure it wraps nicely on smaller screens */
    }

    .summary-card {
        background-color: #fff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 250px; /* Fixed width for each card */
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .summary-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .summary-card h3 {
        font-size: 24px;
        color: #444;
        margin-bottom: 20px;
    }

    .summary-card p {
        font-size: 32px;
        font-weight: bold;
        color: #007BFF;
    }
</style>
