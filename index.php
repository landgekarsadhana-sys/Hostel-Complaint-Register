<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Complaint Register</title>
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

    <h2>Lodge a New Complaint</h2>
    <p style="margin-bottom: 20px; color: #64748b;">
        Fill in all fields. All inputs are handled using parameterized SQL statements.
    </p>

    <form action="save.php" method="POST">
        <div class="form-group">
            <label for="student_name">Full Name *</label>
            <input type="text" id="student_name" name="student_name"
                   required maxlength="100"
                   placeholder="e.g., Aarav Sharma">
        </div>

        <div class="form-group">
            <label for="room_number">Hostel Room Number *</label>
            <input type="text" id="room_number" name="room_number"
                   required maxlength="20"
                   placeholder="e.g., Block B - 204">
        </div>

        <div class="form-group">
            <label for="category">Issue Category *</label>
            <select id="category" name="category" required>
                <option value="">-- Select Category --</option>
                <option value="Electrical">Electrical (Fan, Light, Wiring)</option>
                <option value="Plumbing">Plumbing (Leakage, Tap, Flush)</option>
                <option value="Furniture">Furniture (Bed, Study Table, Cupboard)</option>
                <option value="Internet/LAN">Internet / Wi-Fi / LAN</option>
                <option value="Cleanliness">Cleanliness & Hygiene</option>
                <option value="Other">Other Issues</option>
            </select>
        </div>

        <div class="form-group">
            <label for="description">Detailed Description *</label>
            <textarea id="description" name="description"
                      required maxlength="500"
                      placeholder="Describe the problem in detail..."></textarea>
        </div>

        <button type="submit">Submit Complaint</button>
    </form>
</div>
</body>
</html>