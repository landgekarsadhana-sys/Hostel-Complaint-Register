<?php
require_once 'config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int)($_POST['id'] ?? 0);
    $new_status = $_POST['status'] ?? '';

    if (in_array($new_status, ['Open', 'In Progress', 'Resolved'])) {

        $update_sql = "UPDATE complaints SET status = ? WHERE id = ?";

        $stmt = mysqli_prepare($conn, $update_sql);

        mysqli_stmt_bind_param(
            $stmt,
            "si",
            $new_status,
            $id
        );

        if (mysqli_stmt_execute($stmt)) {

            mysqli_stmt_close($stmt);
            mysqli_close($conn);

            header("Location: view.php");
            exit();

        } else {

            $msg = "Update failed. Please try again.";
        }
    }
}

// Fetch current complaint details
$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM complaints WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

$record = mysqli_fetch_assoc(
    mysqli_stmt_get_result($stmt)
);

mysqli_stmt_close($stmt);

if (!$record) {
    die("Record not found.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Update Complaint Status</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <header>

        <h1>Update Complaint Status</h1>

        <nav>
            <a href="index.php">Register Complaint</a>
            <a href="view.php">View All Complaints</a>
        </nav>

    </header>


    <?php if ($msg): ?>

        <div class="alert alert-danger">

            <?php
            echo htmlspecialchars(
                $msg,
                ENT_QUOTES,
                'UTF-8'
            );
            ?>

        </div>

    <?php endif; ?>


    <p>
        <strong>Complaint ID:</strong>
        #<?php echo (int)$record['id']; ?>
    </p>

    <p>
        <strong>Student Name:</strong>
        <?php
        echo htmlspecialchars(
            $record['student_name'],
            ENT_QUOTES,
            'UTF-8'
        );
        ?>
    </p>

    <p>
        <strong>Room:</strong>
        <?php
        echo htmlspecialchars(
            $record['room_number'],
            ENT_QUOTES,
            'UTF-8'
        );
        ?>
    </p>

    <p>
        <strong>Description:</strong>
        <?php
        echo htmlspecialchars(
            $record['description'],
            ENT_QUOTES,
            'UTF-8'
        );
        ?>
    </p>

    <br>


    <form action="update.php" method="POST">

        <input
            type="hidden"
            name="id"
            value="<?php echo (int)$record['id']; ?>"
        >


        <div class="form-group">

            <label for="status">
                Change Status
            </label>

            <select
                name="status"
                id="status"
                required
            >

                <option
                    value="Open"
                    <?php
                    if ($record['status'] === 'Open')
                        echo 'selected';
                    ?>
                >
                    Open
                </option>

                <option
                    value="In Progress"
                    <?php
                    if ($record['status'] === 'In Progress')
                        echo 'selected';
                    ?>
                >
                    In Progress
                </option>

                <option
                    value="Resolved"
                    <?php
                    if ($record['status'] === 'Resolved')
                        echo 'selected';
                    ?>
                >
                    Resolved
                </option>

            </select>

        </div>


        <button type="submit">
            Save Changes
        </button>

        <a
            href="view.php"
            class="btn"
            style="background:#64748b;"
        >
            Cancel
        </a>

    </form>

</div>

</body>

</html>