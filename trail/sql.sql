CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registration_number VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'student') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert a sample admin account
INSERT INTO users (registration_number, password, role) 
VALUES ('admin', MD5('adminpassword'), 'admin');


-- FEATURES:
-- 1. This SQL file creates a 'subjects' table to store the subject names and credit points for different courses/programs and semesters.
-- 2. The table includes an auto-incrementing ID, the course/program, the semester, subject name, and credit points.
-- 3. Two sets of subjects are inserted for MCA 1st Year (Semester 1 and Semester 2).
-- 4. Easily extendable: You can add more courses, semesters, and subjects as required.
-- 5. Provided queries to fetch subjects based on course/program and semester.
-- 6. The table is designed to prevent duplicate subject entries by using a combination of course/program and semester.
-- 7. Credit point storage allows numeric operations (e.g., calculations for GPA/CGPA).

-- SUGGESTIONS:
-- 1. **Normalizing the Database**: You may want to create separate tables for 'courses/programs' and 'subjects' to normalize the structure. This can help avoid data duplication and improve querying performance.
-- 2. **Add Constraints**: Add more constraints like UNIQUE (to prevent subject duplication) and FOREIGN KEY (if you normalize the structure and link tables).
-- 3. **Indexing**: Consider adding indexes to frequently queried columns (e.g., 'course_program' and 'semester') for faster retrieval.
-- 4. **Data Validation**: Ensure that only valid data (e.g., valid credit points and correct semester values) is inserted by adding validation logic in your application layer.
-- 5. **Future Proofing**: Plan for additional semesters and courses by setting up an easy-to-expand system.


-- Create the subjects table
CREATE TABLE IF NOT EXISTS subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_program VARCHAR(50) NOT NULL,  -- Course/Program column
    semester INT NOT NULL,
    subject_name VARCHAR(100) NOT NULL,
    credits INT NOT NULL
);

-- Insert MCA 1st Year Semester 1 subjects with their credit points
INSERT INTO subjects (course_program, semester, subject_name, credits) VALUES
('MCA', 1, 'Computer Programming with C', 4),
('MCA', 1, 'Data Structures with C', 5),
('MCA', 1, 'Object-Oriented Programming (C++)', 5),
('MCA', 1, 'Database Management System I', 5),
('MCA', 1, 'Business English and Communication', 3);

-- Insert MCA 1st Year Semester 2 subjects with their credit points
INSERT INTO subjects (course_program, semester, subject_name, credits) VALUES
('MCA', 2, 'Operating Systems and Systems Software', 5),
('MCA', 2, 'Statistics and Numerical Techniques', 3),
('MCA', 2, 'Database Management System II', 6),
('MCA', 2, 'Software Engineering & TQM', 5),
('MCA', 2, 'Business Management', 3),
('MCA', 2, 'Operation Research & Optimisation Techniques', 7);

-- Query to fetch subjects for MCA 1st Year Semester 1
SELECT * FROM subjects WHERE course_program = 'MCA' AND semester = 1;

-- Query to fetch subjects for MCA 1st Year Semester 2
SELECT * FROM subjects WHERE course_program = 'MCA' AND semester = 2;

-- Query to fetch all subjects for MCA 1st Year (Both Semester 1 and 2)
SELECT * FROM subjects WHERE course_program = 'MCA' AND (semester = 1 OR semester = 2);


CREATE TABLE student_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(255) NOT NULL,
    registration_number VARCHAR(50) NOT NULL,
    section VARCHAR(10) NOT NULL,
    course VARCHAR(255) NOT NULL,
    semester INT NOT NULL,
    sgpa DECIMAL(4, 3) NOT NULL,
    cgpa DECIMAL(4, 3) NOT NULL,
    overall_result VARCHAR(10) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE subject_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    result_id INT NOT NULL,
    subject_name VARCHAR(255) NOT NULL,
    credits INT NOT NULL,
    grade VARCHAR(10) NOT NULL,
    grade_point DECIMAL(3, 2) NOT NULL,
    FOREIGN KEY (result_id) REFERENCES student_results(id) ON DELETE CASCADE
);