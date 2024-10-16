-- USERS TABLE: Stores both admin and student users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registration_number VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'student') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert a sample admin account
INSERT INTO users (registration_number, password, role) 
VALUES ('admin', MD5('adminpassword'), 'admin')
ON DUPLICATE KEY UPDATE registration_number = registration_number;

-- COURSES TABLE: Stores course/program details for normalization
CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_program VARCHAR(50) NOT NULL,
    UNIQUE(course_program) -- Ensure each course/program is unique
);

-- SUBJECTS TABLE: Stores subject details linked to courses and semesters
CREATE TABLE IF NOT EXISTS subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,  -- Foreign key to 'courses'
    semester INT NOT NULL,
    subject_name VARCHAR(100) NOT NULL,
    credits INT NOT NULL,
    UNIQUE(course_id, semester, subject_name),  -- Prevent duplicate subjects
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Insert MCA and BCA programs into courses table (if not already inserted)
INSERT INTO courses (course_program) 
VALUES ('MCA') 
ON DUPLICATE KEY UPDATE course_program = course_program;

INSERT INTO courses (course_program) 
VALUES ('BCA') 
ON DUPLICATE KEY UPDATE course_program = course_program;

-- Insert MCA 1st Year Semester 1 subjects
INSERT INTO subjects (course_id, semester, subject_name, credits) VALUES
((SELECT id FROM courses WHERE course_program = 'MCA'), 1, 'Computer Programming with C', 4),
((SELECT id FROM courses WHERE course_program = 'MCA'), 1, 'Data Structures with C', 5),
((SELECT id FROM courses WHERE course_program = 'MCA'), 1, 'Object-Oriented Programming (C++)', 5),
((SELECT id FROM courses WHERE course_program = 'MCA'), 1, 'Database Management System I', 5),
((SELECT id FROM courses WHERE course_program = 'MCA'), 1, 'Business English and Communication', 3);

-- Insert MCA 1st Year Semester 2 subjects
INSERT INTO subjects (course_id, semester, subject_name, credits) VALUES
((SELECT id FROM courses WHERE course_program = 'MCA'), 2, 'Operating Systems and Systems Software', 5),
((SELECT id FROM courses WHERE course_program = 'MCA'), 2, 'Statistics and Numerical Techniques', 3),
((SELECT id FROM courses WHERE course_program = 'MCA'), 2, 'Database Management System II', 6),
((SELECT id FROM courses WHERE course_program = 'MCA'), 2, 'Software Engineering & TQM', 5),
((SELECT id FROM courses WHERE course_program = 'MCA'), 2, 'Business Management', 3),
((SELECT id FROM courses WHERE course_program = 'MCA'), 2, 'Operation Research & Optimisation Techniques', 7);

-- Insert MCA 2nd Year Semester 3 subjects
INSERT INTO subjects (course_id, semester, subject_name, credits) VALUES
((SELECT id FROM courses WHERE course_program = 'MCA'), 3, 'Data Mining and Application', 5),
((SELECT id FROM courses WHERE course_program = 'MCA'), 3, 'Artificial Intelligence', 6),
((SELECT id FROM courses WHERE course_program = 'MCA'), 3, 'Internet and Web Technology', 4),
((SELECT id FROM courses WHERE course_program = 'MCA'), 3, 'Machine Learning using Python', 5),
((SELECT id FROM courses WHERE course_program = 'MCA'), 3, 'Seminar', 2);

-- Insert MCA 2nd Year Semester 4 subjects
INSERT INTO subjects (course_id, semester, subject_name, credits) VALUES
((SELECT id FROM courses WHERE course_program = 'MCA'), 4, 'Mobile Application Development', 6),
((SELECT id FROM courses WHERE course_program = 'MCA'), 4, 'Deep Learning', 4),
((SELECT id FROM courses WHERE course_program = 'MCA'), 4, 'Software Testing', 4),
((SELECT id FROM courses WHERE course_program = 'MCA'), 4, 'Project', 10);

-- Insert BCA 1st Year Semester 1 subjects
INSERT INTO subjects (course_id, semester, subject_name, credits) VALUES
((SELECT id FROM courses WHERE course_program = 'BCA'), 1, 'Mathematics', 5),
((SELECT id FROM courses WHERE course_program = 'BCA'), 1, 'C language', 4),
((SELECT id FROM courses WHERE course_program = 'BCA'), 1, 'C++', 5),
((SELECT id FROM courses WHERE course_program = 'BCA'), 1, 'HTML+CSS', 4),
((SELECT id FROM courses WHERE course_program = 'BCA'), 1, 'JavaScript', 5);

-- Insert BCA 1st Year Semester 2 subjects
INSERT INTO subjects (course_id, semester, subject_name, credits) VALUES
((SELECT id FROM courses WHERE course_program = 'BCA'), 2, 'JavaScript Library + Advance', 5),
((SELECT id FROM courses WHERE course_program = 'BCA'), 2, 'Framework', 3),
((SELECT id FROM courses WHERE course_program = 'BCA'), 2, 'Java Language', 5),
((SELECT id FROM courses WHERE course_program = 'BCA'), 2, 'Database (MySQL, MongoDB)', 5);

-- Insert BCA 2nd Year Semester 3 subjects
INSERT INTO subjects (course_id, semester, subject_name, credits) VALUES
((SELECT id FROM courses WHERE course_program = 'BCA'), 3, 'Data Mining and Application', 4),
((SELECT id FROM courses WHERE course_program = 'BCA'), 3, 'Django', 5),
((SELECT id FROM courses WHERE course_program = 'BCA'), 3, 'PHP', 5),
((SELECT id FROM courses WHERE course_program = 'BCA'), 3, 'Machine Learning using Python', 5),
((SELECT id FROM courses WHERE course_program = 'BCA'), 3, 'Seminar', 2);

-- Insert BCA 2nd Year Semester 4 subjects
INSERT INTO subjects (course_id, semester, subject_name, credits) VALUES
((SELECT id FROM courses WHERE course_program = 'BCA'), 4, 'MERN Stack', 7),
((SELECT id FROM courses WHERE course_program = 'BCA'), 4, 'DSA using Python', 5),
((SELECT id FROM courses WHERE course_program = 'BCA'), 4, 'Android Developer (App)', 5),
((SELECT id FROM courses WHERE course_program = 'BCA'), 4, 'Project', 7);

-- Insert BCA 3rd Year Semester 5 subjects
INSERT INTO subjects (course_id, semester, subject_name, credits) VALUES
((SELECT id FROM courses WHERE course_program = 'BCA'), 5, 'AWS', 5),
((SELECT id FROM courses WHERE course_program = 'BCA'), 5, 'MERN Stack 2', 5),
((SELECT id FROM courses WHERE course_program = 'BCA'), 5, 'Android Developer (App) 2', 6),
((SELECT id FROM courses WHERE course_program = 'BCA'), 5, 'Interview Preparation', 3),
((SELECT id FROM courses WHERE course_program = 'BCA'), 5, 'DSA 2', 5);

-- Insert BCA 3rd Year Semester 6 subjects
INSERT INTO subjects (course_id, semester, subject_name, credits) VALUES
((SELECT id FROM courses WHERE course_program = 'BCA'), 6, 'Cyber Security', 6),
((SELECT id FROM courses WHERE course_program = 'BCA'), 6, 'Artificial Intelligence', 6),
((SELECT id FROM courses WHERE course_program = 'BCA'), 6, 'Project', 10);


-- STUDENT RESULTS TABLE: Stores general student results
CREATE TABLE IF NOT EXISTS student_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(255) NOT NULL,
    registration_number VARCHAR(50) NOT NULL,
    section VARCHAR(10) NOT NULL,
    course_id INT NOT NULL,  -- Foreign key to 'courses'
    semester INT NOT NULL,
    sgpa DECIMAL(4, 3) NOT NULL,
    cgpa DECIMAL(4, 3) NOT NULL,
    overall_result VARCHAR(10) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- SUBJECT RESULTS TABLE: Stores detailed subject-wise results for each student result
CREATE TABLE IF NOT EXISTS subject_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    result_id INT NOT NULL,  -- Foreign key to 'student_results'
    subject_name VARCHAR(255) NOT NULL,
    credits INT NOT NULL,
    grade VARCHAR(10) NOT NULL,
    grade_point DECIMAL(3, 2) NOT NULL,
    FOREIGN KEY (result_id) REFERENCES student_results(id) ON DELETE CASCADE
);

-- Query to fetch subjects for MCA 1st Year Semester 1
SELECT * FROM subjects 
WHERE course_id = (SELECT id FROM courses WHERE course_program = 'MCA') 
AND semester = 1;

-- Query to fetch subjects for MCA 1st Year Semester 2
SELECT * FROM subjects 
WHERE course_id = (SELECT id FROM courses WHERE course_program = 'MCA') 
AND semester = 2;

-- Query to fetch all subjects for MCA 1st Year (Both Semester 1 and 2)
SELECT * FROM subjects 
WHERE course_id = (SELECT id FROM courses WHERE course_program = 'MCA') 
AND semester IN (1, 2);


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


-- Key Optimizations:
-- Normalization: A courses table is added, linking subjects and student results to avoid repetition of course names.
-- Unique Constraints: Unique constraints prevent duplicate entries in both users and subjects tables.
-- Foreign Keys: Proper foreign key relationships ensure data integrity, with ON DELETE CASCADE for automatic deletion of dependent records.
-- Simplified Insertions: Insert operations for subjects use subqueries to reference the correct course_id dynamically.
-- Scalability: The structure is easily extendable for additional courses, semesters, and subjects.
-- This optimized SQL setup is ready for use, ensuring better performance and maintainability.