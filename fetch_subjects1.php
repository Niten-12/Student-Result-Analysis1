<?php
require './db/db.php'; 

$program = $_POST['program'];
$semester = $_POST['semester'];

// Fetch the course_id for the selected program
$stmt = $pdo->prepare("SELECT id FROM courses WHERE course_program = ?");
$stmt->execute([$program]);
$course = $stmt->fetch(PDO::FETCH_ASSOC);

if ($course) {
    $course_id = $course['id'];

    // Fetch the subjects for the selected course_id and semester
    $stmt = $pdo->prepare("SELECT subject_name FROM subjects WHERE course_id = ? AND semester = ?");
    $stmt->execute([$course_id, $semester]);
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<option value="">Select Subject</option>';
    foreach ($subjects as $subject) {
        echo '<option value="' . $subject['subject_name'] . '">' . $subject['subject_name'] . '</option>';
    }
} else {
    echo '<option value="">No subjects available</option>';
}
?>



<?php
// require './db/db.php'; 

// $program = $_POST['program'];
// $semester = $_POST['semester'];

// $stmt = $pdo->prepare("SELECT subject_name FROM subjects WHERE course_program = ? AND semester = ?");
// $stmt->execute([$program, $semester]);
// $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// echo '<option value="">Select Subject</option>';
// foreach ($subjects as $subject) {
//     echo '<option value="' . $subject['subject_name'] . '">' . $subject['subject_name'] . '</option>';
// }
?>
