INSERT INTO users (registration_number, password, role) VALUES
(226101, MD5('226101@Bca'), 'student'),
(226102, MD5('226102@Bca'), 'student'),
(226103, MD5('226103@Bca'), 'student'),
(226104, MD5('226104@Bca'), 'student'),
(226105, MD5('226105@Bca'), 'student'),
(226106, MD5('226106@Bca'), 'student'),
(226107, MD5('226107@Bca'), 'student'),
(226108, MD5('226108@Bca'), 'student'),
(226109, MD5('226109@Bca'), 'student'),
(226110, MD5('226110@Bca'), 'student'),
(226111, MD5('226111@Bca'), 'student'),
(226112, MD5('226112@Bca'), 'student'),
(226113, MD5('226113@Bca'), 'student'),
(226114, MD5('226114@Bca'), 'student'),
(226115, MD5('226115@Bca'), 'student'),
(226116, MD5('226116@Bca'), 'student'),
(226117, MD5('226117@Bca'), 'student'),
(226118, MD5('226118@Bca'), 'student'),
(226119, MD5('226119@Bca'), 'student'),
(226120, MD5('226120@Bca'), 'student'),
(226121, MD5('226121@Bca'), 'student'),
(226122, MD5('226122@Bca'), 'student'),
(226123, MD5('226123@Bca'), 'student'),
(226124, MD5('226124@Bca'), 'student'),
(226125, MD5('226125@Bca'), 'student'),
(226126, MD5('226126@Bca'), 'student'),
(226127, MD5('226127@Bca'), 'student'),
(226128, MD5('226128@Bca'), 'student'),
(226129, MD5('226129@Bca'), 'student'),
(226130, MD5('226130@Bca'), 'student'),
(226131, MD5('226131@Bca'), 'student'),
(226132, MD5('226132@Bca'), 'student'),
(226133, MD5('226133@Bca'), 'student'),
(226134, MD5('226134@Bca'), 'student'),
(226135, MD5('226135@Bca'), 'student'),
(226136, MD5('226136@Bca'), 'student'),
(226137, MD5('226137@Bca'), 'student'),
(226138, MD5('226138@Bca'), 'student'),
(226139, MD5('226139@Bca'), 'student'),
(226140, MD5('226140@Bca'), 'student');

-- Insert 30 MCA students (id 41 to 70) with MD5 hashed passwords
INSERT INTO users (registration_number, password, role) VALUES
(222401, MD5('222401@Mca'), 'student'),
(222402, MD5('222402@Mca'), 'student'),
(222403, MD5('222403@Mca'), 'student'),
(222404, MD5('222404@Mca'), 'student'),
(222405, MD5('222405@Mca'), 'student'),
(222406, MD5('222406@Mca'), 'student'),
(222407, MD5('222407@Mca'), 'student'),
(222408, MD5('222408@Mca'), 'student'),
(222409, MD5('222409@Mca'), 'student'),
(222410, MD5('222410@Mca'), 'student'),
(222411, MD5('222411@Mca'), 'student'),
(222412, MD5('222412@Mca'), 'student'),
(222413, MD5('222413@Mca'), 'student'),
(222414, MD5('222414@Mca'), 'student'),
(222415, MD5('222415@Mca'), 'student'),
(222416, MD5('222416@Mca'), 'student'),
(222417, MD5('222417@Mca'), 'student'),
(222418, MD5('222418@Mca'), 'student'),
(222419, MD5('222419@Mca'), 'student'),
(222420, MD5('222420@Mca'), 'student'),
(222421, MD5('222421@Mca'), 'student'),
(222422, MD5('222422@Mca'), 'student'),
(222423, MD5('222423@Mca'), 'student'),
(222424, MD5('222424@Mca'), 'student'),
(222425, MD5('222425@Mca'), 'student'),
(222426, MD5('222426@Mca'), 'student'),
(222427, MD5('222427@Mca'), 'student'),
(222428, MD5('222428@Mca'), 'student'),
(222429, MD5('222429@Mca'), 'student'),
(222430, MD5('222430@Mca'), 'student');

-- Inserting student results for BCA students with specified CGPA distribution
INSERT INTO student_results (student_name, registration_number, section, course_id, semester, sgpa, cgpa, overall_result)
VALUES
('Aarav Kumar', '226101', 'A', 2, 1, 7.2, 7.3, 'Pass'),
('Vivaan Singh', '226102', 'A', 2, 1, 7.8, 7.9, 'Pass'),
('Diya Gupta', '226103', 'A', 2, 1, 7.5, 7.6, 'Pass'),
('Sai Reddy', '226104', 'A', 2, 1, 6.9, 7.0, 'Pass'),
('Ishaan Dev', '226105', 'A', 2, 1, 7.1, 7.2, 'Pass'),
('Tiya Sharma', '226106', 'A', 2, 1, 7.6, 7.7, 'Pass'),
('Om Kapoor', '226107', 'A', 2, 1, 6.8, 6.9, 'Pass'),
('Zara Khan', '226108', 'A', 2, 1, 7.3, 7.4, 'Pass'),
('Kavya Singh', '226109', 'A', 2, 1, 7.7, 7.8, 'Pass'),
('Rohan Das', '226110', 'A', 2, 1, 8.1, 8.2, 'Pass'),
('Maya Prasad', '226111', 'A', 2, 1, 8.5, 8.6, 'Pass'),
('Karan Sood', '226112', 'A', 2, 1, 8.3, 8.4, 'Pass'),
('Anika Roy', '226113', 'B', 2, 1, 5.4, 5.6, 'Fail'), -- Fail
('Ritvik Banerjee', '226114', 'B', 2, 1, 8.7, 8.8, 'Pass'),
('Siya Kumar', '226115', 'B', 2, 1, 9.1, 9.2, 'Pass'),
('Arjun Reddy', '226116', 'B', 2, 1, 9.3, 9.4, 'Pass'),
('Nia Sharma', '226117', 'B', 2, 1, 5.8, 5.9, 'Fail'), -- Fail
('Vihaan Dutta', '226118', 'B', 2, 1, 9.0, 9.1, 'Pass'),
('Aadhya Bisht', '226119', 'B', 2, 1, 9.2, 9.3, 'Pass'),
('Yuvraj Singh', '226120', 'B', 2, 1, 8.8, 8.9, 'Pass'),
('Meera Chopra', '226121', 'B', 2, 1, 8.6, 8.7, 'Pass'),
('Ayaan Ali', '226122', 'B', 2, 1, 8.4, 8.5, 'Pass'),
('Tara Reddy', '226123', 'B', 2, 1, 9.4, 9.5, 'Pass'),
('Vikram Jain', '226124', 'B', 2, 1, 6.2, 6.5, 'Fail'), -- Fail
('Aditi Patel', '226125', 'C', 2, 1, 9.1, 9.2, 'Pass'),
('Rishi Khanna', '226126', 'C', 2, 1, 9.3, 9.4, 'Pass'),
('Lakshmi Reddy', '226127', 'C', 2, 1, 7.0, 7.1, 'Pass'),
('Soham Khan', '226128', 'C', 2, 1, 7.9, 8.0, 'Pass'),
('Mia Kapoor', '226129', 'C', 2, 1, 10.0, 10.0, 'Pass'), -- One student with perfect CGPA
('Jay Shah', '226130', 'C', 2, 1, 9.0, 9.1, 'Pass'),
('Nikhil Nair', '226131', 'C', 2, 1, 5.9, 6.1, 'Fail'), -- Fail
('Ananya Singh', '226132', 'C', 2, 1, 6.0, 6.2, 'Fail'), -- Fail
('Omar Farooq', '226133', 'C', 2, 1, 9.5, 9.6, 'Pass'),
('Priya Desai', '226134', 'C', 2, 1, 9.2, 9.3, 'Pass'),
('Rahul Bose', '226135', 'C', 2, 1, 9.4, 9.5, 'Pass'),
('Sara Ali', '226136', 'C', 2, 1, 9.1, 9.2, 'Pass'),
('Mohit Verma', '226137', 'C', 2, 1, 5.5, 5.7, 'Fail'), -- Fail
('Tanvi Chopra', '226138', 'C', 2, 1, 5.3, 5.5, 'Fail'), -- Fail
('Kunal Bhatia', '226139', 'C', 2, 1, 9.0, 9.1, 'Pass'),
('Neha Goyal', '226140', 'C', 2, 1, 9.3, 9.4, 'Pass');

-- Inserting student results for MCA students with specified CGPA distribution
INSERT INTO student_results (student_name, registration_number, section, course_id, semester, sgpa, cgpa, overall_result)
VALUES
('Priyanka Bose', '222401', 'A', 1, 1, 7.2, 7.3, 'Pass'),
('Nitin Joshi', '222402', 'A', 1, 1, 7.8, 7.9, 'Pass'),
('Manisha Koirala', '222403', 'A', 1, 1, 7.5, 7.6, 'Pass'),
('Karan Nath', '222404', 'A', 1, 1, 6.9, 7.0, 'Pass'),
('Jyoti Singh', '222405', 'A', 1, 1, 7.1, 7.2, 'Pass'),
('Rajesh Khattar', '222406', 'A', 1, 1, 7.6, 7.7, 'Pass'),
('Lakshmi Gopal', '222407', 'A', 1, 1, 8.1, 8.2, 'Pass'),
('Sunil Grover', '222408', 'A', 1, 1, 8.5, 8.6, 'Pass'),
('Harish Kalyan', '222409', 'A', 1, 1, 8.3, 8.4, 'Pass'),
('Simran Kaur', '222410', 'A', 1, 1, 8.7, 8.8, 'Pass'),
('Mohan Joshi', '222411', 'A', 1, 1, 9.1, 9.2, 'Pass'),
('Pooja Bhatt', '222412', 'A', 1, 1, 9.3, 9.4, 'Pass'),
('Vinod Kamble', '222413', 'A', 1, 1, 9.0, 9.1, 'Pass'),
('Harpreet Kaur', '222414', 'B', 1, 1, 9.2, 9.3, 'Pass'),
('Gagan Deep', '222415', 'B', 1, 1, 9.4, 9.5, 'Pass'),
('Sarita Joshi', '222416', 'B', 1, 1, 5.4, 5.6, 'Fail'), -- Fail
('Om Prakash', '222417', 'B', 1, 1, 5.8, 5.9, 'Fail'), -- Fail
('Kavita Krishnan', '222418', 'B', 1, 1, 9.5, 9.6, 'Pass'),
('Narendra Singh', '222419', 'B', 1, 1, 10.0, 10.0, 'Pass'), -- One student with perfect CGPA
('Manoj Bajpai', '222420', 'B', 1, 1, 7.0, 7.1, 'Pass'),
('Leela Samson', '222421', 'B', 1, 1, 7.9, 8.0, 'Pass'),
('Anirudh Dave', '222422', 'B', 1, 1, 6.8, 6.9, 'Pass'),
('Smita Patil', '222423', 'B', 1, 1, 8.6, 8.7, 'Pass'),
('Rajat Kapoor', '222424', 'B', 1, 1, 8.4, 8.5, 'Pass'),
('Naseeruddin Shah', '222425', 'B', 1, 1, 6.2, 6.5, 'Fail'), -- Fail
('Kirti Kulhari', '222426', 'B', 1, 1, 5.9, 6.1, 'Fail'), -- Fail
('Paresh Rawal', '222427', 'B', 1, 1, 6.0, 6.2, 'Fail'), -- Fail
('Radhika Apte', '222428', 'B', 1, 1, 8.8, 8.9, 'Pass'),
('Irfan Khan', '222429', 'B', 1, 1, 5.5, 5.7, 'Fail'), -- Fail
('Tisca Chopra', '222430', 'B', 1, 1, 9.1, 9.2, 'Pass');





INSERT INTO subject_results (result_id, subject_name, credits, grade, grade_point)
VALUES
-- Student 1: Aarav Kumar
(1, 'Mathematics', 5, 'A', 9.00),
(1, 'C language', 4, 'B', 8.00),
(1, 'C++', 5, 'A', 9.00),
(1, 'HTML+CSS', 4, 'B', 8.00),
(1, 'JavaScript', 5, 'A', 9.00),

-- Student 2: Vivaan Singh
(2, 'Mathematics', 5, 'B', 8.00),
(2, 'C language', 4, 'A++', 10.00),
(2, 'C++', 5, 'A', 9.00),
(2, 'HTML+CSS', 4, 'A++', 10.00),
(2, 'JavaScript', 5, 'B', 8.00),

-- Student 3: Diya Gupta
(3, 'Mathematics', 5, 'A', 9.00),
(3, 'C language', 4, 'C', 7.00),
(3, 'C++', 5, 'B', 8.00),
(3, 'HTML+CSS', 4, 'A', 9.00),
(3, 'JavaScript', 5, 'B', 8.00),

-- Student 4: Sai Reddy
(4, 'Mathematics', 5, 'C', 7.00),
(4, 'C language', 4, 'B', 8.00),
(4, 'C++', 5, 'C', 7.00),
(4, 'HTML+CSS', 4, 'D', 6.00),
(4, 'JavaScript', 5, 'F', 0.00), -- Fail in JavaScript

-- Student 5: Ishaan Dev
(5, 'Mathematics', 5, 'B', 8.00),
(5, 'C language', 4, 'A', 9.00),
(5, 'C++', 5, 'A', 9.00),
(5, 'HTML+CSS', 4, 'C', 7.00),
(5, 'JavaScript', 5, 'B', 8.00),

-- Student 6: Tiya Sharma
(6, 'Mathematics', 5, 'B', 8.00),
(6, 'C language', 4, 'C', 7.00),
(6, 'C++', 5, 'B', 8.00),
(6, 'HTML+CSS', 4, 'A++', 10.00),
(6, 'JavaScript', 5, 'B', 8.00),

-- Student 7: Om Kapoor
(7, 'Mathematics', 5, 'A', 9.00),
(7, 'C language', 4, 'C', 7.00),
(7, 'C++', 5, 'D', 6.00),
(7, 'HTML+CSS', 4, 'F', 0.00), -- Fail in HTML+CSS
(7, 'JavaScript', 5, 'C', 7.00),

-- Student 8: Zara Khan
(8, 'Mathematics', 5, 'A++', 10.00),
(8, 'C language', 4, 'B', 8.00),
(8, 'C++', 5, 'A', 9.00),
(8, 'HTML+CSS', 4, 'B', 8.00),
(8, 'JavaScript', 5, 'A++', 10.00),

-- Student 9: Kavya Singh
(9, 'Mathematics', 5, 'A', 9.00),
(9, 'C language', 4, 'C', 7.00),
(9, 'C++', 5, 'B', 8.00),
(9, 'HTML+CSS', 4, 'A', 9.00),
(9, 'JavaScript', 5, 'B', 8.00),

-- Student 10: Rohan Das
(10, 'Mathematics', 5, 'A++', 10.00),
(10, 'C language', 4, 'A', 9.00),
(10, 'C++', 5, 'A', 9.00),
(10, 'HTML+CSS', 4, 'B', 8.00),
(10, 'JavaScript', 5, 'A', 9.00),

-- Student 11: Maya Prasad
(11, 'Mathematics', 5, 'B', 8.00),
(11, 'C language', 4, 'A', 9.00),
(11, 'C++', 5, 'B', 8.00),
(11, 'HTML+CSS', 4, 'A++', 10.00),
(11, 'JavaScript', 5, 'B', 8.00),

-- Student 12: Karan Sood
(12, 'Mathematics', 5, 'C', 7.00),
(12, 'C language', 4, 'B', 8.00),
(12, 'C++', 5, 'A', 9.00),
(12, 'HTML+CSS', 4, 'B', 8.00),
(12, 'JavaScript', 5, 'C', 7.00),

-- Student 13: Anika Roy (Failing Student)
(13, 'Mathematics', 5, 'F', 0.00), -- Fail in Mathematics
(13, 'C language', 4, 'D', 6.00),
(13, 'C++', 5, 'E', 5.00),
(13, 'HTML+CSS', 4, 'F', 0.00), -- Fail in HTML+CSS
(13, 'JavaScript', 5, 'C', 7.00),

-- Student 14: Ritvik Banerjee
(14, 'Mathematics', 5, 'B', 8.00),
(14, 'C language', 4, 'A++', 10.00),
(14, 'C++', 5, 'A', 9.00),
(14, 'HTML+CSS', 4, 'A', 9.00),
(14, 'JavaScript', 5, 'B', 8.00),

-- Student 15: Siya Kumar
(15, 'Mathematics', 5, 'A++', 10.00),
(15, 'C language', 4, 'A', 9.00),
(15, 'C++', 5, 'A', 9.00),
(15, 'HTML+CSS', 4, 'B', 8.00),
(15, 'JavaScript', 5, 'A', 9.00),

-- Student 16: Arjun Reddy
(16, 'Mathematics', 5, 'B', 8.00),
(16, 'C language', 4, 'A', 9.00),
(16, 'C++', 5, 'A++', 10.00),
(16, 'HTML+CSS', 4, 'B', 8.00),
(16, 'JavaScript', 5, 'B', 8.00),

-- Student 17: Nia Sharma (Failing Student)
(17, 'Mathematics', 5, 'D', 6.00),
(17, 'C language', 4, 'F', 0.00), -- Fail in C language
(17, 'C++', 5, 'C', 7.00),
(17, 'HTML+CSS', 4, 'E', 5.00),
(17, 'JavaScript', 5, 'F', 0.00), -- Fail in JavaScript

-- Student 18: Vihaan Dutta
(18, 'Mathematics', 5, 'A', 9.00),
(18, 'C language', 4, 'A++', 10.00),
(18, 'C++', 5, 'B', 8.00),
(18, 'HTML+CSS', 4, 'B', 8.00),
(18, 'JavaScript', 5, 'A', 9.00),

-- Student 19: Aadhya Bisht
(19, 'Mathematics', 5, 'B', 8.00),
(19, 'C language', 4, 'A', 9.00),
(19, 'C++', 5, 'A++', 10.00),
(19, 'HTML+CSS', 4, 'B', 8.00),
(19, 'JavaScript', 5, 'A', 9.00),

-- Student 20: Yuvraj Singh
(20, 'Mathematics', 5, 'A++', 10.00),
(20, 'C language', 4, 'B', 8.00),
(20, 'C++', 5, 'A', 9.00),
(20, 'HTML+CSS', 4, 'B', 8.00),
(20, 'JavaScript', 5, 'A++', 10.00),

-- Student 21: Meera Chopra
(21, 'Mathematics', 5, 'A', 9.00),
(21, 'C language', 4, 'B', 8.00),
(21, 'C++', 5, 'A++', 10.00),
(21, 'HTML+CSS', 4, 'B', 8.00),
(21, 'JavaScript', 5, 'A', 9.00),

-- Student 22: Ayaan Ali
(22, 'Mathematics', 5, 'B', 8.00),
(22, 'C language', 4, 'A++', 10.00),
(22, 'C++', 5, 'A', 9.00),
(22, 'HTML+CSS', 4, 'A', 9.00),
(22, 'JavaScript', 5, 'B', 8.00),

-- Student 23: Tara Reddy
(23, 'Mathematics', 5, 'A++', 10.00),
(23, 'C language', 4, 'B', 8.00),
(23, 'C++', 5, 'A', 9.00),
(23, 'HTML+CSS', 4, 'A', 9.00),
(23, 'JavaScript', 5, 'A++', 10.00),

-- Student 24: Vikram Jain (Failing Student)
(24, 'Mathematics', 5, 'F', 0.00), -- Fail in Mathematics
(24, 'C language', 4, 'C', 7.00),
(24, 'C++', 5, 'B', 8.00),
(24, 'HTML+CSS', 4, 'F', 0.00), -- Fail in HTML+CSS
(24, 'JavaScript', 5, 'D', 6.00),

-- Student 25: Aditi Patel
(25, 'Mathematics', 5, 'A', 9.00),
(25, 'C language', 4, 'A', 9.00),
(25, 'C++', 5, 'A++', 10.00),
(25, 'HTML+CSS', 4, 'B', 8.00),
(25, 'JavaScript', 5, 'A', 9.00),

-- Student 26: Rishi Khanna
(26, 'Mathematics', 5, 'A', 9.00),
(26, 'C language', 4, 'A++', 10.00),
(26, 'C++', 5, 'B', 8.00),
(26, 'HTML+CSS', 4, 'A', 9.00),
(26, 'JavaScript', 5, 'A++', 10.00),

-- Student 27: Lakshmi Reddy
(27, 'Mathematics', 5, 'C', 7.00),
(27, 'C language', 4, 'B', 8.00),
(27, 'C++', 5, 'C', 7.00),
(27, 'HTML+CSS', 4, 'B', 8.00),
(27, 'JavaScript', 5, 'B', 8.00),

-- Student 28: Soham Khan
(28, 'Mathematics', 5, 'B', 8.00),
(28, 'C language', 4, 'A++', 10.00),
(28, 'C++', 5, 'A', 9.00),
(28, 'HTML+CSS', 4, 'A', 9.00),
(28, 'JavaScript', 5, 'A++', 10.00),

-- Student 29: Mia Kapoor
(29, 'Mathematics', 5, 'A++', 10.00),
(29, 'C language', 4, 'A++', 10.00),
(29, 'C++', 5, 'A++', 10.00),
(29, 'HTML+CSS', 4, 'A++', 10.00),
(29, 'JavaScript', 5, 'A++', 10.00), -- Perfect score student

-- Student 30: Jay Shah
(30, 'Mathematics', 5, 'A', 9.00),
(30, 'C language', 4, 'B', 8.00),
(30, 'C++', 5, 'A', 9.00),
(30, 'HTML+CSS', 4, 'B', 8.00),
(30, 'JavaScript', 5, 'A', 9.00),

-- Student 31: Nikhil Nair (Failing Student)
(31, 'Mathematics', 5, 'F', 0.00), -- Fail in Mathematics
(31, 'C language', 4, 'D', 6.00),
(31, 'C++', 5, 'E', 5.00),
(31, 'HTML+CSS', 4, 'F', 0.00), -- Fail in HTML+CSS
(31, 'JavaScript', 5, 'C', 7.00),

-- Student 32: Ananya Singh (Failing Student)
(32, 'Mathematics', 5, 'D', 6.00),
(32, 'C language', 4, 'C', 7.00),
(32, 'C++', 5, 'F', 0.00), -- Fail in C++
(32, 'HTML+CSS', 4, 'E', 5.00),
(32, 'JavaScript', 5, 'F', 0.00), -- Fail in JavaScript

-- Student 33: Omar Farooq
(33, 'Mathematics', 5, 'A', 9.00),
(33, 'C language', 4, 'B', 8.00),
(33, 'C++', 5, 'A++', 10.00),
(33, 'HTML+CSS', 4, 'A', 9.00),
(33, 'JavaScript', 5, 'A++', 10.00),

-- Student 34: Priya Desai
(34, 'Mathematics', 5, 'A', 9.00),
(34, 'C language', 4, 'A++', 10.00),
(34, 'C++', 5, 'B', 8.00),
(34, 'HTML+CSS', 4, 'A', 9.00),
(34, 'JavaScript', 5, 'A++', 10.00),

-- Student 35: Rahul Bose
(35, 'Mathematics', 5, 'A', 9.00),
(35, 'C language', 4, 'B', 8.00),
(35, 'C++', 5, 'A', 9.00),
(35, 'HTML+CSS', 4, 'A++', 10.00),
(35, 'JavaScript', 5, 'B', 8.00),

-- Student 36: Sara Ali
(36, 'Mathematics', 5, 'B', 8.00),
(36, 'C language', 4, 'A++', 10.00),
(36, 'C++', 5, 'A', 9.00),
(36, 'HTML+CSS', 4, 'A', 9.00),
(36, 'JavaScript', 5, 'A', 9.00),

-- Student 37: Mohit Verma (Failing Student)
(37, 'Mathematics', 5, 'F', 0.00), -- Fail in Mathematics
(37, 'C language', 4, 'D', 6.00),
(37, 'C++', 5, 'F', 0.00), -- Fail in C++
(37, 'HTML+CSS', 4, 'C', 7.00),
(37, 'JavaScript', 5, 'E', 5.00),

-- Student 38: Tanvi Chopra (Failing Student)
(38, 'Mathematics', 5, 'F', 0.00), -- Fail in Mathematics
(38, 'C language', 4, 'F', 0.00), -- Fail in C language
(38, 'C++', 5, 'D', 6.00),
(38, 'HTML+CSS', 4, 'C', 7.00),
(38, 'JavaScript', 5, 'E', 5.00),

-- Student 39: Kunal Bhatia
(39, 'Mathematics', 5, 'A++', 10.00),
(39, 'C language', 4, 'A', 9.00),
(39, 'C++', 5, 'A++', 10.00),
(39, 'HTML+CSS', 4, 'A', 9.00),
(39, 'JavaScript', 5, 'A++', 10.00),

-- Student 40: Neha Goyal
(40, 'Mathematics', 5, 'A', 9.00),
(40, 'C language', 4, 'A', 9.00),
(40, 'C++', 5, 'B', 8.00),
(40, 'HTML+CSS', 4, 'A++', 10.00),
(40, 'JavaScript', 5, 'A', 9.00);

INSERT INTO subject_results (result_id, subject_name, credits, grade, grade_point)
VALUES
-- Student 1: Priyanka Bose (result_id = 41)
(41, 'Computer Programming with C', 4, 'A', 9.00),
(41, 'Data Structures with C', 5, 'B', 8.00),
(41, 'Object-Oriented Programming (C++)', 5, 'A++', 10.00),
(41, 'Database Management System I', 5, 'A', 9.00),
(41, 'Business English and Communication', 3, 'A++', 10.00),

-- Student 2: Nitin Joshi (result_id = 42)
(42, 'Computer Programming with C', 4, 'A++', 10.00),
(42, 'Data Structures with C', 5, 'A', 9.00),
(42, 'Object-Oriented Programming (C++)', 5, 'A', 9.00),
(42, 'Database Management System I', 5, 'A++', 10.00),
(42, 'Business English and Communication', 3, 'A', 9.00),

-- Student 3: Manisha Koirala (Failing) (result_id = 43)
(43, 'Computer Programming with C', 4, 'F', 0.00), -- Fail in Computer Programming
(43, 'Data Structures with C', 5, 'C', 7.00),
(43, 'Object-Oriented Programming (C++)', 5, 'B', 8.00),
(43, 'Database Management System I', 5, 'C', 7.00),
(43, 'Business English and Communication', 3, 'B', 8.00),

-- Student 4: Karan Nath (Failing) (result_id = 44)
(44, 'Computer Programming with C', 4, 'B', 8.00),
(44, 'Data Structures with C', 5, 'ABSENT', 0.00), -- Absent in Data Structures
(44, 'Object-Oriented Programming (C++)', 5, 'C', 7.00),
(44, 'Database Management System I', 5, 'C', 7.00),
(44, 'Business English and Communication', 3, 'A', 9.00),

-- Student 5: Jyoti Singh (result_id = 45)
(45, 'Computer Programming with C', 4, 'A', 9.00),
(45, 'Data Structures with C', 5, 'B', 8.00),
(45, 'Object-Oriented Programming (C++)', 5, 'A++', 10.00),
(45, 'Database Management System I', 5, 'A', 9.00),
(45, 'Business English and Communication', 3, 'A++', 10.00),

-- Student 6: Rajesh Khattar (result_id = 46)
(46, 'Computer Programming with C', 4, 'A++', 10.00),
(46, 'Data Structures with C', 5, 'A', 9.00),
(46, 'Object-Oriented Programming (C++)', 5, 'B', 8.00),
(46, 'Database Management System I', 5, 'A', 9.00),
(46, 'Business English and Communication', 3, 'A', 9.00),

-- Student 7: Lakshmi Gopal (Failing) (result_id = 47)
(47, 'Computer Programming with C', 4, 'F', 0.00), -- Fail in Computer Programming
(47, 'Data Structures with C', 5, 'F', 0.00), -- Fail in Data Structures
(47, 'Object-Oriented Programming (C++)', 5, 'D', 6.00),
(47, 'Database Management System I', 5, 'C', 7.00),
(47, 'Business English and Communication', 3, 'C', 7.00),

-- Student 8: Sunil Grover (result_id = 48)
(48, 'Computer Programming with C', 4, 'A++', 10.00),
(48, 'Data Structures with C', 5, 'B', 8.00),
(48, 'Object-Oriented Programming (C++)', 5, 'A', 9.00),
(48, 'Database Management System I', 5, 'A++', 10.00),
(48, 'Business English and Communication', 3, 'A', 9.00),

-- Student 9: Harish Kalyan (Failing) (result_id = 49)
(49, 'Computer Programming with C', 4, 'ABSENT', 0.00), -- Absent in Computer Programming
(49, 'Data Structures with C', 5, 'B', 8.00),
(49, 'Object-Oriented Programming (C++)', 5, 'ABSENT', 0.00), -- Absent in OOP
(49, 'Database Management System I', 5, 'C', 7.00),
(49, 'Business English and Communication', 3, 'B', 8.00),

-- Student 10: Simran Kaur (result_id = 50)
(50, 'Computer Programming with C', 4, 'A++', 10.00),
(50, 'Data Structures with C', 5, 'A', 9.00),
(50, 'Object-Oriented Programming (C++)', 5, 'A', 9.00),
(50, 'Database Management System I', 5, 'A', 9.00),
(50, 'Business English and Communication', 3, 'A++', 10.00),

-- Student 11: Mohan Joshi (result_id = 51)
(51, 'Computer Programming with C', 4, 'A', 9.00),
(51, 'Data Structures with C', 5, 'A++', 10.00),
(51, 'Object-Oriented Programming (C++)', 5, 'B', 8.00),
(51, 'Database Management System I', 5, 'A', 9.00),
(51, 'Business English and Communication', 3, 'A++', 10.00),

-- Student 12: Pooja Bhatt (result_id = 52)
(52, 'Computer Programming with C', 4, 'A', 9.00),
(52, 'Data Structures with C', 5, 'A++', 10.00),
(52, 'Object-Oriented Programming (C++)', 5, 'B', 8.00),
(52, 'Database Management System I', 5, 'A++', 10.00),
(52, 'Business English and Communication', 3, 'A++', 10.00),

-- Student 13: Vinod Kamble (Failing) (result_id = 53)
(53, 'Computer Programming with C', 4, 'F', 0.00), -- Fail in Computer Programming
(53, 'Data Structures with C', 5, 'B', 8.00),
(53, 'Object-Oriented Programming (C++)', 5, 'C', 7.00),
(53, 'Database Management System I', 5, 'B', 8.00),
(53, 'Business English and Communication', 3, 'A++', 10.00),

-- Student 14: Harpreet Kaur (result_id = 54)
(54, 'Computer Programming with C', 4, 'A', 9.00),
(54, 'Data Structures with C', 5, 'A++', 10.00),
(54, 'Object-Oriented Programming (C++)', 5, 'A', 9.00),
(54, 'Database Management System I', 5, 'A', 9.00),
(54, 'Business English and Communication', 3, 'A++', 10.00),

-- Student 15: Gagan Deep (Failing) (result_id = 55)
(55, 'Computer Programming with C', 4, 'ABSENT', 0.00), -- Absent in Computer Programming
(55, 'Data Structures with C', 5, 'A', 9.00),
(55, 'Object-Oriented Programming (C++)', 5, 'A', 9.00),
(55, 'Database Management System I', 5, 'A', 9.00),
(55, 'Business English and Communication', 3, 'A++', 10.00),

-- Student 16: Sarita Joshi (Failing) (result_id = 56)
(56, 'Computer Programming with C', 4, 'F', 0.00), -- Fail in Computer Programming
(56, 'Data Structures with C', 5, 'F', 0.00), -- Fail in Data Structures
(56, 'Object-Oriented Programming (C++)', 5, 'D', 6.00),
(56, 'Database Management System I', 5, 'C', 7.00),
(56, 'Business English and Communication', 3, 'C', 7.00),

-- Student 17: Om Prakash (Failing) (result_id = 57)
(57, 'Computer Programming with C', 4, 'B', 8.00),
(57, 'Data Structures with C', 5, 'ABSENT', 0.00), -- Absent in Data Structures
(57, 'Object-Oriented Programming (C++)', 5, 'C', 7.00),
(57, 'Database Management System I', 5, 'C', 7.00),
(57, 'Business English and Communication', 3, 'A', 9.00),

-- Student 18: Kavita Krishnan (result_id = 58)
(58, 'Computer Programming with C', 4, 'A++', 10.00),
(58, 'Data Structures with C', 5, 'B', 8.00),
(58, 'Object-Oriented Programming (C++)', 5, 'A', 9.00),
(58, 'Database Management System I', 5, 'A', 9.00),
(58, 'Business English and Communication', 3, 'A++', 10.00),

-- Student 19: Narendra Singh (Failing) (result_id = 59)
(59, 'Computer Programming with C', 4, 'F', 0.00), -- Fail in Computer Programming
(59, 'Data Structures with C', 5, 'C', 7.00),
(59, 'Object-Oriented Programming (C++)', 5, 'C', 7.00),
(59, 'Database Management System I', 5, 'B', 8.00),
(59, 'Business English and Communication', 3, 'A', 9.00),

-- Student 20: Manoj Bajpai (result_id = 60)
(60, 'Computer Programming with C', 4, 'A++', 10.00),
(60, 'Data Structures with C', 5, 'A', 9.00),
(60, 'Object-Oriented Programming (C++)', 5, 'A', 9.00),
(60, 'Database Management System I', 5, 'A++', 10.00),
(60, 'Business English and Communication', 3, 'A++', 10.00),

-- Student 21: Leela Samson (result_id = 61)
(61, 'Computer Programming with C', 4, 'A++', 10.00),
(61, 'Data Structures with C', 5, 'B', 8.00),
(61, 'Object-Oriented Programming (C++)', 5, 'A', 9.00),
(61, 'Database Management System I', 5, 'A', 9.00),
(61, 'Business English and Communication', 3, 'A++', 10.00),

-- Student 22: Anirudh Dave (result_id = 62)
(62, 'Computer Programming with C', 4, 'A', 9.00),
(62, 'Data Structures with C', 5, 'A++', 10.00),
(62, 'Object-Oriented Programming (C++)', 5, 'A', 9.00),
(62, 'Database Management System I', 5, 'A++', 10.00),
(62, 'Business English and Communication', 3, 'A', 9.00),

-- Student 23: Smita Patil (Failing) (result_id = 63)
(63, 'Computer Programming with C', 4, 'ABSENT', 0.00), -- Absent in Computer Programming
(63, 'Data Structures with C', 5, 'B', 8.00),
(63, 'Object-Oriented Programming (C++)', 5, 'ABSENT', 0.00), -- Absent in OOP
(63, 'Database Management System I', 5, 'C', 7.00),
(63, 'Business English and Communication', 3, 'B', 8.00),

-- Student 24: Rajat Kapoor (result_id = 64)
(64, 'Computer Programming with C', 4, 'A', 9.00),
(64, 'Data Structures with C', 5, 'A++', 10.00),
(64, 'Object-Oriented Programming (C++)', 5, 'B', 8.00),
(64, 'Database Management System I', 5, 'A++', 10.00),
(64, 'Business English and Communication', 3, 'A', 9.00),

-- Student 25: Naseeruddin Shah (result_id = 65)
(65, 'Computer Programming with C', 4, 'A', 9.00),
(65, 'Data Structures with C', 5, 'B', 8.00),
(65, 'Object-Oriented Programming (C++)', 5, 'A++', 10.00),
(65, 'Database Management System I', 5, 'A', 9.00),
(65, 'Business English and Communication', 3, 'A', 9.00),

-- Student 26: Kirti Kulhari (Failing) (result_id = 66)
(66, 'Computer Programming with C', 4, 'F', 0.00), -- Fail in Computer Programming
(66, 'Data Structures with C', 5, 'C', 7.00),
(66, 'Object-Oriented Programming (C++)', 5, 'C', 7.00),
(66, 'Database Management System I', 5, 'B', 8.00),
(66, 'Business English and Communication', 3, 'A', 9.00),

-- Student 27: Paresh Rawal (result_id = 67)
(67, 'Computer Programming with C', 4, 'A++', 10.00),
(67, 'Data Structures with C', 5, 'A', 9.00),
(67, 'Object-Oriented Programming (C++)', 5, 'A', 9.00),
(67, 'Database Management System I', 5, 'A++', 10.00),
(67, 'Business English and Communication', 3, 'A++', 10.00),

-- Student 28: Radhika Apte (Failing) (result_id = 68)
(68, 'Computer Programming with C', 4, 'B', 8.00),
(68, 'Data Structures with C', 5, 'ABSENT', 0.00), -- Absent in Data Structures
(68, 'Object-Oriented Programming (C++)', 5, 'A', 9.00),
(68, 'Database Management System I', 5, 'B', 8.00),
(68, 'Business English and Communication', 3, 'A', 9.00),

-- Student 29: Irfan Khan (Failing) (result_id = 69)
(69, 'Computer Programming with C', 4, 'F', 0.00), -- Fail in Computer Programming
(69, 'Data Structures with C', 5, 'F', 0.00), -- Fail in Data Structures
(69, 'Object-Oriented Programming (C++)', 5, 'D', 6.00),
(69, 'Database Management System I', 5, 'C', 7.00),
(69, 'Business English and Communication', 3, 'B', 8.00),

-- Student 30: Tisca Chopra (result_id = 70)
(70, 'Computer Programming with C', 4, 'A++', 10.00),
(70, 'Data Structures with C', 5, 'A', 9.00),
(70, 'Object-Oriented Programming (C++)', 5, 'A++', 10.00),
(70, 'Database Management System I', 5, 'A', 9.00),
(70, 'Business English and Communication', 3, 'A++', 10.00);
