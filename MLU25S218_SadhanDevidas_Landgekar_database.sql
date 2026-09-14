-- Database Schema for Hostel Complaint Register
CREATE TABLE IF NOT EXISTS complaints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    room_number VARCHAR(20) NOT NULL,
    category VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    status ENUM('Open', 'In Progress', 'Resolved') DEFAULT 'Open',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample Records
INSERT INTO complaints (student_name, room_number, category, description, status) VALUES
('Aarav Sharma', 'B-204', 'Electrical', 'Ceiling fan is making loud rattling noise.', 'Open'),
('Pooja Patel', 'G-102', 'Plumbing', 'Washbasin tap is continuously leaking.', 'In Progress'),
('Karan Verma', 'C-315', 'Furniture', 'Study table drawer slider is broken.', 'Resolved'),
('O\'Reilly Miller', 'A-108', 'Internet/LAN', 'LAN port in room is not establishing connection.', 'Open');
