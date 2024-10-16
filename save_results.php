<?php
// Include database connection
require './db/db.php'; 

// Get the raw POST data (JSON format)
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if ($data) {
    // Extract data from the received JSON
    $studentName = $data['student_name'];
    $registrationNumber = $data['registration_number'];
    $section = $data['section'];
    $course = $data['course'];  // 'MCA', 'BCA', etc.
    $semester = $data['semester'];
    $subjects = $data['subjects'];
    $sgpa = $data['sgpa'];
    $cgpa = $data['cgpa'];
    $overallResult = $data['overall_result'];

    try {
        // Start database transaction
        $pdo->beginTransaction();
    
        // Insert student results
        $stmt = $pdo->prepare('
            INSERT INTO student_results (student_name, registration_number, section, course_id, semester, sgpa, cgpa, overall_result) 
            VALUES (?, ?, ?, (SELECT id FROM courses WHERE course_program = ?), ?, ?, ?, ?)
        ');
        $stmt->execute([$studentName, $registrationNumber, $section, $course, $semester, $sgpa, $cgpa, $overallResult]);
    
        // Get the last inserted student result ID
        $resultId = $pdo->lastInsertId();
    
        // Prepare the bulk insert query for subject results
        $subjectInsertQuery = 'INSERT INTO subject_results (result_id, subject_name, credits, grade, grade_point) VALUES ';
        $insertValues = [];
        $insertParams = [];
    
        // Loop through each subject and prepare values for bulk insertion
        foreach ($subjects as $subject) {
            $insertValues[] = '(?, ?, ?, ?, ?)';
            array_push($insertParams, $resultId, $subject['subject_name'], $subject['credits'], $subject['grade'], $subject['grade_point']);
        }
    
        // Execute bulk insert query
        $subjectInsertQuery .= implode(', ', $insertValues);
        $stmt = $pdo->prepare($subjectInsertQuery);
        $stmt->execute($insertParams);
    
        // Commit the transaction after both inserts are done
        $pdo->commit();
    
        // Return success response
        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        // Roll back the transaction in case of an error
        $pdo->rollBack();
        error_log('Error: ' . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    
} else {
    // Handle invalid input
    echo json_encode(['status' => 'error', 'message' => 'Invalid input data.']);
}
?>
