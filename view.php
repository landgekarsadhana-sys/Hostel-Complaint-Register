<?php
require_once 'config.php';

// Safe handling of search/filter
$status_filter = trim($_GET['status'] ?? '');
$search_query  = trim($_GET['search'] ?? '');

$sql = "SELECT id, student_name, room_number, category, description, status, created_at
        FROM complaints
        WHERE 1=1";

$params = [];
$types = "";

if ($status_filter !== '' &&
    in_array($status_filter, ['Open', 'In Progress', 'Resolved'])) {

    $sql .= " AND status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

if ($search_query !== '') {

    $sql .= " AND (student_name LIKE ? OR room_number LIKE ?)";

    $like_val = "%" . $search_query . "%";

    $params[] = $like_val;
    $params[] = $like_val;

    $types .= "ss";
}

$sql .= " ORDER BY id DESC";

$stmt = mysqli_prepare($conn, $sql);

if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Complaint Records</title>

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

    <h2>Registered Complaints</h2>

    <!-- Search and Filter Form -->

    <form method="GET"
          action="view.php"
          style="margin: 20px 0; display: flex; gap: 10px; flex-wrap: wrap;">

        <input
            type="text"
            name="search"
            placeholder="Search by name or room..."
            value="<?php echo htmlspecialchars($search_query, ENT_QUOTES, 'UTF-8'); ?>"
            style="flex: 1; min-width: 180px;"
        >

        <select name="status" style="width: auto;">

            <option value="">All Statuses</option>

            <option value="Open"
                <?php if ($status_filter === 'Open') echo 'selected'; ?>>
                Open
            </option>

            <option value="In Progress"
                <?php if ($status_filter === 'In Progress') echo 'selected'; ?>>
                In Progress
            </option>

            <option value="Resolved"
                <?php if ($status_filter === 'Resolved') echo 'selected'; ?>>
                Resolved
            </option>

        </select>

        <button type="submit">
            Filter / Search
        </button>

        <a href="view.php"
           class="btn"
           style="background:#64748b;">
            Reset
        </a>

    </form>


    <table>

        <thead>

            <tr>
                <th>ID</th>
                <th>Student</th>
                <th>Room</th>
                <th>Category</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

        </thead>

        <tbody>

        <?php if ($result && mysqli_num_rows($result) > 0): ?>

            <?php while ($row = mysqli_fetch_assoc($result)): ?>

                <tr>

                    <td>
                        <?php echo (int)$row['id']; ?>
                    </td>

                    <td>
                        <?php
                        echo htmlspecialchars(
                            $row['student_name'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>
                    </td>

                    <td>
                        <?php
                        echo htmlspecialchars(
                            $row['room_number'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>
                    </td>

                    <td>
                        <?php
                        echo htmlspecialchars(
                            $row['category'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>
                    </td>

                    <td>
                        <?php
                        echo nl2br(
                            htmlspecialchars(
                                $row['description'],
                                ENT_QUOTES,
                                'UTF-8'
                            )
                        );
                        ?>
                    </td>

                    <td>

                        <?php

                        $badge_class = 'badge-open';

                        if ($row['status'] === 'In Progress') {
                            $badge_class = 'badge-progress';
                        }

                        if ($row['status'] === 'Resolved') {
                            $badge_class = 'badge-resolved';
                        }

                        ?>

                        <span class="badge <?php echo $badge_class; ?>">

                            <?php
                            echo htmlspecialchars(
                                $row['status'],
                                ENT_QUOTES,
                                'UTF-8'
                            );
                            ?>

                        </span>

                    </td>

                    <td>

                        <a
                            href="update.php?id=<?php echo (int)$row['id']; ?>"
                            style="color:#2563eb; font-weight:600;"
                        >
                            Update Status
                        </a>

                    </td>

                </tr>

            <?php endwhile; ?>

        <?php else: ?>

            <tr>

                <td
                    colspan="7"
                    style="text-align:center; color:#64748b;"
                >
                    No complaints found matching criteria.
                </td>

            </tr>

        <?php endif; ?>

        </tbody>

    </table>

</div>

</body>

</html>

<?php

mysqli_stmt_close($stmt);

mysqli_close($conn);

?>