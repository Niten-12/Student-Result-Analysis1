<?php
// save_results.php
require './db/db.php'; 

// Get the raw POST data (JSON format)
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if ($data) {
    $studentName = $data['student_name'];
    $registrationNumber = $data['registration_number'];
    $section = $data['section'];
    $course = $data['course'];
    $semester = $data['semester'];
    $subjects = $data['subjects'];
    $sgpa = $data['sgpa'];
    $cgpa = $data['cgpa'];
    $overallResult = $data['overall_result'];

    try {
        $pdo->beginTransaction();

        // Insert student results
        $stmt = $pdo->prepare('INSERT INTO student_results (student_name, registration_number, section, course, semester, sgpa, cgpa, overall_result) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$studentName, $registrationNumber, $section, $course, $semester, $sgpa, $cgpa, $overallResult]);

        $resultId = $pdo->lastInsertId();

        // Prepare bulk insert for subject results
        $subjectInsert = 'INSERT INTO subject_results (result_id, subject_name, credits, grade, grade_point) VALUES ';
        $insertValues = [];
        $insertParams = [];

        foreach ($subjects as $subject) {
            $insertValues[] = '(?, ?, ?, ?, ?)';
            array_push($insertParams, $resultId, $subject['subject_name'], $subject['credits'], $subject['grade'], $subject['grade_point']);
        }

        // Combine the query for bulk insertion
        $subjectInsert .= implode(', ', $insertValues);
        $stmt = $pdo->prepare($subjectInsert);
        $stmt->execute($insertParams);

        $pdo->commit();

        // Return success response after commit
        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log('Error: ' . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input data.']);
}
?>


//save_results.php
// require './db/db.php'; 

// Get the raw POST data (JSON format)
// $input = file_get_contents('php://input');
// $data = json_decode($input, true);

// Extract data from the decoded array
// $studentName = $data['student_name'];
// $registrationNumber = $data['registration_number'];
// $section = $data['section'];
// $course = $data['course'];
// $semester = $data['semester'];
// $subjects = $data['subjects'];
// $sgpa = $data['sgpa'];
// $cgpa = $data['cgpa'];
// $overallResult = $data['overall_result'];

// try {
//     $pdo->beginTransaction();

    // Insert student results into the database
    // $stmt = $pdo->prepare('INSERT INTO student_results (student_name, registration_number, section, course, semester, sgpa, cgpa, overall_result) 
    //                         VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    // $stmt->execute([$studentName, $registrationNumber, $section, $course, $semester, $sgpa, $cgpa, $overallResult]);

    // $resultId = $pdo->lastInsertId();

    // Insert each subject result
//     foreach ($subjects as $subject) {
//         $stmt = $pdo->prepare('INSERT INTO subject_results (result_id, subject_name, credits, grade, grade_point) 
//                                 VALUES (?, ?, ?, ?, ?)');
//         $stmt->execute([$resultId, $subject['subject_name'], $subject['credits'], $subject['grade'], $subject['grade_point']]);
//     }

//     $pdo->commit();
//     echo 'Success';
// } catch (PDOException $e) {
//     $pdo->rollBack();
//     error_log('Error: ' . $e->getMessage());
//     echo 'Error: ' . $e->getMessage();
// }

// $studentName = $_POST['student_name'];
// $registrationNumber = $_POST['registration_number'];
// $section = $_POST['section'];
// $course = $_POST['course'];
// $semester = $_POST['semester'];
// $subjects = json_decode($_POST['subjects'], true);  // Decode subjects JSON
// $sgpa = $_POST['sgpa'];
// $cgpa = $_POST['cgpa'];
// $overallResult = $_POST['overall_result'];

// Save the data into the database
// Your database logic here for saving the result
// Example:
// foreach ($subjects as $subject) {
//     $stmt = $pdo->prepare("INSERT INTO results (student_name, reg_no, course, semester, subject_name, credits, grade, grade_point, sgpa, cgpa, result) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
//     $stmt->execute([$studentName, $registrationNumber, $course, $semester, $subject['subject_name'], $subject['credits'], $subject['grade'], $subject['grade_point'], $sgpa, $cgpa, $overallResult]);
// }
 
