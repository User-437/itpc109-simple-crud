USE student_db;

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_no VARCHAR(30) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    course VARCHAR(100) NOT NULL,
    year_level INT NOT NULL,
    email VARCHAR(100) NOT NULL
);

INSERT INTO students
(student_no, full_name, course, year_level, email)
VALUES
('2026-001', 'Juan Dela Cruz', 'BSIT', 1, 'juan@example.com'),
('2026-002', 'Maria Santos', 'BSIT', 2, 'maria@example.com'),
('2026-003', 'Pedro Reyes', 'BSCS', 1, 'pedro@example.com');