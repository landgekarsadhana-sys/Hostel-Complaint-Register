<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get and clean form input
    $student_name = trim($_POST['student_name'] ?? '');
    $room_number  = trim($_POST['room_number'] ?? '');
    $category     = trim($_POST['category'] ?? '');
    $description  = trim($_POST['description'] ?? '');

    // Server-side validation
    if (empty($student_name) || empty($room_number) || empty($category) || empty($description)) {
        $error_msg = "All fields are compulsory. Please fill all fields.";
    } else {

        // Prepared INSERT statement
        $sql = "INSERT INTO complaints 
                (student_name, room_number, category, description) 
                VALUES (?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {

            // Four string parameters
            mysqli_stmt_bind_param(
                $stmt,
                "ssss",
                $student_name,
                $room_number,
                $category,
                $description
            );

            if (mysqli_stmt_execute($stmt)) {
                $success = true;
            } else {
                $error_msg = "Could not register complaint due to a server error.";
            }

            mysqli_stmt_close($stmt);

        } else {
            $error_msg = "Database statement preparation failed.";
        }
    }

    mysqli_close($conn);

} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submission Status</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <header>
        <h1>Hostel Maintenance & Complaint Portal</h1>

        <nav>
            <a href="index.php">Register Complaint</a>
            <a href="view.php">View All Complaints</a>
        </nav>
    </header>

    <?php if (!empty($success)): ?>

        <div class="alert alert-success">
            <h3>Complaint Registered Successfully!</h3>

            <p>
                Your ticket has been logged and the maintenance team
                will attend to it shortly.
            </p>
        </div>

        <a href="view.php" class="btn">View All Complaints</a>

        <a href="index.php" class="btn" style="background:#475569;">
            Register Another
        </a>

    <?php else: ?>

        <div class="alert alert-danger">

            <h3>Submission Failed</h3>

            <p>
                <?php
                echo htmlspecialchars(
                    $error_msg,
                    ENT_QUOTES,
                    'UTF-8'
                );
                ?>
            </p>

        </div>

        <a href="index.php" class="btn">
            Return to Form
        </a>

    <?php endif; ?>

</div>

</body>
</html>