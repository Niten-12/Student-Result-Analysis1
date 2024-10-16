<?php
require './db/db.php';
session_start();

// Security Enhancement: Regenerate session ID to prevent session fixation attacks
session_regenerate_id(true);

// Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('Invalid request method');
}

// Validate CSRF Token (ensure you have a CSRF token mechanism)
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    exit('Invalid CSRF token');
}

// Input validation and sanitization
$program = filter_input(INPUT_POST, 'program', FILTER_SANITIZE_STRING);
$semester = filter_input(INPUT_POST, 'semester', FILTER_VALIDATE_INT);
$reportType = filter_input(INPUT_POST, 'reportType', FILTER_SANITIZE_STRING);
$section = isset($_POST['section']) ? filter_input(INPUT_POST, 'section', FILTER_SANITIZE_STRING) : null;
$subject = isset($_POST['subject']) ? filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING) : null;

if (!$program || !$semester || !$reportType) {
    exit('Required fields are missing');
}

// Fetch the course_id for the selected program
$courseStmt = $pdo->prepare("SELECT id FROM courses WHERE course_program = ?");
$courseStmt->execute([$program]);
$course = $courseStmt->fetch(PDO::FETCH_ASSOC);

if (!$course) {
    exit('Invalid program selected');
}

$course_id = $course['id'];

// Basic SQL query to fetch student details from student_results
$query = "SELECT id, student_name, registration_number, section, sgpa, cgpa, overall_result 
          FROM student_results 
          WHERE course_id = :course_id AND semester = :semester";

$params = [
    ':course_id' => $course_id,
    ':semester' => $semester
];

// Add optional filters for section
if ($section) {
    $query .= " AND section = :section";
    $params[':section'] = $section;
}

// Execute query
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if any results were returned
if (!$results) {
    exit('No data found for the selected options.');
}

?>

<!-- Include required libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

<!-- JavaScript functions for exporting and printing -->
<script>
    function exportTableToCSV(tableID, filename) {
        let csv = [];
        let rows = document.querySelectorAll(`#${tableID} tr`);
        
        for (let row of rows) {
            let cols = row.querySelectorAll('td, th');
            let rowArray = Array.from(cols).map(col => `"${col.innerText}"`);
            csv.push(rowArray.join(','));
        }

        let csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
        let downloadLink = document.createElement("a");
        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }

    function exportTableToExcel(tableID, filename) {
        let table = document.getElementById(tableID);
        let workbook = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});

        setTimeout(() => {
            XLSX.writeFile(workbook, filename);
        }, 100);
    }

    function exportTableToPDF(tableID, filename) {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        const table = document.getElementById(tableID);
        const rows = [...table.querySelectorAll('tr')].map(tr => [...tr.querySelectorAll('th, td')].map(td => td.innerText));

        setTimeout(() => {
            doc.autoTable({
                head: [rows[0]], // Table header
                body: rows.slice(1), // Table body
                styles: { fontSize: 10, halign: 'center' },
            });
            doc.save(filename);
        }, 100);
    }

    function printTable(tableID) {
        let table = document.getElementById(tableID);
        if (!table) {
            console.error("Table not found!");
            return;
        }
        let printContents = table.outerHTML;
        let originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        window.location.reload(); // Reload the page to restore original content after print
    }
</script>

<?php
// Process report type
if ($reportType == 'pass') {
    // Filter results where the overall result is 'Pass'
    $results = array_filter($results, fn($r) => $r['overall_result'] == 'Pass');

    // Display the table with a manually generated serial number
    echo '<table class="table" id="passTable">';
    echo '<thead><tr><th>Serial No.</th><th>Student Name</th><th>Registration Number</th><th>Section</th><th>CGPA</th><th>Result</th></tr></thead>';
    echo '<tbody>';

    // Initialize a serial number counter
    $serialNo = 1;

    // Loop through the results to generate the table rows
    foreach ($results as $row) {
        echo '<tr>';
        // Assign the serial number manually
        echo '<td>' . $serialNo++ . '</td>';
        echo "<td>{$row['student_name']}</td>";
        echo "<td>{$row['registration_number']}</td>";
        echo "<td>{$row['section']}</td>";
        echo "<td>{$row['cgpa']}</td>";
        echo "<td>{$row['overall_result']}</td>";
        echo '</tr>';
    }

    echo '</tbody></table>';
} elseif ($reportType == 'fail') {
    $results = array_filter($results, fn($r) => $r['overall_result'] == 'Fail');

    // Fetch failed subjects in a single query
    $ids = array_column($results, 'id');
    if ($ids) {
        $placeholders = str_repeat('?,', count($ids) - 1) . '?';

        $stmt = $pdo->prepare("SELECT result_id, subject_name, grade 
                               FROM subject_results 
                               WHERE result_id IN ($placeholders) 
                               AND (grade = 'F' OR grade = 'Absent')");
        $stmt->execute($ids);
        $subjectFailures = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);
    } else {
        $subjectFailures = [];
    }

    // Display fail list
    echo '<table class="table" id="failTable">';
    echo '<thead><tr><th>Serial No.</th><th>Student Name</th><th>Registration Number</th><th>Section</th><th>CGPA</th><th>Result</th><th>Failed/Absent Subjects</th></tr></thead>';
    echo '<tbody>';

    $serialNo = 1;
    foreach ($results as $row) {
        echo '<tr>';
        echo '<td>' . $serialNo++ . '</td>';
        echo "<td>{$row['student_name']}</td>";
        echo "<td>{$row['registration_number']}</td>";
        echo "<td>{$row['section']}</td>";
        echo "<td>{$row['cgpa']}</td>";
        echo "<td>{$row['overall_result']}</td>";
        echo '<td>';
        if (isset($subjectFailures[$row['id']])) {
            foreach ($subjectFailures[$row['id']] as $subject) {
                echo "{$subject['subject_name']} ({$subject['grade']})<br>";
            }
        } else {
            echo "No failed or absent subjects";
        }
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody></table>';

} elseif ($reportType == 'subject_wise') {
    // Fetch all subject data in a single query
    $stmt = $pdo->prepare("SELECT sr.result_id, sr.subject_name, sr.grade, sr.grade_point, 
                                  st.student_name, st.registration_number, st.section
                           FROM subject_results sr 
                           JOIN student_results st ON sr.result_id = st.id 
                           WHERE st.course_id = :course_id AND st.semester = :semester");
    $stmt->execute([':course_id' => $course_id, ':semester' => $semester]);
    $subjectData = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);

    echo '<table class="table" id="subjectWiseTable">';
    echo '<thead><tr><th>Serial No.</th><th>Student Name</th><th>Registration Number</th><th>Section</th><th>Subject</th><th>Grade</th><th>Grade Point</th><th>Subject Result</th></tr></thead>';
    echo '<tbody>';

    $serialNo = 1;
    foreach ($subjectData as $resultId => $subjects) {
        foreach ($subjects as $subject) {
            echo '<tr>';
            echo '<td>' . $serialNo++ . '</td>';
            echo "<td>{$subject['student_name']}</td>";
            echo "<td>{$subject['registration_number']}</td>";
            echo "<td>{$subject['section']}</td>";
            echo "<td>{$subject['subject_name']}</td>";
            echo "<td>{$subject['grade']}</td>";
            echo "<td>{$subject['grade_point']}</td>";
            $subjectResult = ($subject['grade'] === 'F' || strtoupper($subject['grade']) === 'ABSENT') ? 'Fail' : 'Pass';
            echo "<td>{$subjectResult}</td>";
            echo '</tr>';
        }
    }
    echo '</tbody></table>';

} elseif ($reportType == 'cgpa_list') {
    usort($results, fn($a, $b) => $b['cgpa'] <=> $a['cgpa']);

    echo '<table class="table" id="cgpaTable">';
    echo '<thead><tr><th>Serial No.</th><th>Student Name</th><th>Registration Number</th><th>Section</th><th>CGPA</th><th>Result</th></tr></thead>';
    echo '<tbody>';
    foreach ($results as $index => $row) {
        echo '<tr>';
        echo '<td>' . ($index + 1) . '</td>';
        echo "<td>{$row['student_name']}</td>";
        echo "<td>{$row['registration_number']}</td>";
        echo "<td>{$row['section']}</td>";
        echo "<td>{$row['cgpa']}</td>";
        echo "<td>{$row['overall_result']}</td>";
        echo '</tr>';
    }
    echo '</tbody></table>';
}
?>

<?php
// require './db/db.php';
// session_start();

// // Security Enhancement: Regenerate session ID to prevent session fixation attacks
// session_regenerate_id(true);

// // Validate request method
// if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
//     exit('Invalid request method');
// }

// // Validate CSRF Token (ensure you have a CSRF token mechanism)
// if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
//     exit('Invalid CSRF token');
// }

// // Input validation and sanitization
// $program = filter_input(INPUT_POST, 'program', FILTER_SANITIZE_STRING);
// $semester = filter_input(INPUT_POST, 'semester', FILTER_VALIDATE_INT);
// $reportType = filter_input(INPUT_POST, 'reportType', FILTER_SANITIZE_STRING);
// $section = isset($_POST['section']) ? filter_input(INPUT_POST, 'section', FILTER_SANITIZE_STRING) : null;
// $subject = isset($_POST['subject']) ? filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING) : null;

// if (!$program || !$semester || !$reportType) {
//     exit('Required fields are missing');
// }

// // Basic SQL query to fetch student details from student_results
// $query = "SELECT id, student_name, registration_number, section, sgpa, cgpa, overall_result 
//           FROM student_results 
//           WHERE course = :program AND semester = :semester";

// $params = [
//     ':program' => $program,
//     ':semester' => $semester
// ];

// // Add optional filters for section
// if ($section) {
//     $query .= " AND section = :section";
//     $params[':section'] = $section;
// }

// // Execute query
// $stmt = $pdo->prepare($query);
// $stmt->execute($params);
// $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// // Check if any results were returned
// if (!$results) {
//     exit('No data found for the selected options.');
// }

// ?>

 <!-- Include required libraries -->
<!-- // <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
// <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
// <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script> -->

 <!-- JavaScript functions for exporting and printing -->
<!-- // <script>
//     function exportTableToCSV(tableID, filename) {
//         let csv = [];
//         let rows = document.querySelectorAll(`#${tableID} tr`);
        
//         for (let row of rows) {
//             let cols = row.querySelectorAll('td, th');
//             let rowArray = Array.from(cols).map(col => `"${col.innerText}"`);
//             csv.push(rowArray.join(','));
//         }

//         let csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
//         let downloadLink = document.createElement("a");
//         downloadLink.download = filename;
//         downloadLink.href = window.URL.createObjectURL(csvFile);
//         downloadLink.style.display = "none";
//         document.body.appendChild(downloadLink);
//         downloadLink.click();
//         document.body.removeChild(downloadLink);
//     }

//     function exportTableToExcel(tableID, filename) {
//         let table = document.getElementById(tableID);
//         let workbook = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});

//         setTimeout(() => {
//             XLSX.writeFile(workbook, filename);
//         }, 100);
//     }

//     function exportTableToPDF(tableID, filename) {
//         const { jsPDF } = window.jspdf;
//         const doc = new jsPDF();

//         const table = document.getElementById(tableID);
//         const rows = [...table.querySelectorAll('tr')].map(tr => [...tr.querySelectorAll('th, td')].map(td => td.innerText));

//         setTimeout(() => {
//             doc.autoTable({
//                 head: [rows[0]], // Table header
//                 body: rows.slice(1), // Table body
//                 styles: { fontSize: 10, halign: 'center' },
//             });
//             doc.save(filename);
//         }, 100);
//     }

//     function printTable(tableID) {
//         let table = document.getElementById(tableID);
//         if (!table) {
//             console.error("Table not found!");
//             return;
//         }
//         let printContents = table.outerHTML;
//         let originalContents = document.body.innerHTML;
//         document.body.innerHTML = printContents;
//         window.print();
//         document.body.innerHTML = originalContents;
//         window.location.reload(); // Reload the page to restore original content after print
//     }
// </script> -->

 <?php
// // Process report type
// if ($reportType == 'pass') {
//     // Filter results where the overall result is 'Pass'
//     $results = array_filter($results, fn($r) => $r['overall_result'] == 'Pass');

//     // Display the table with a manually generated serial number
//     echo '<table class="table" id="passTable">';
//     echo '<thead><tr><th>Serial No.</th><th>Student Name</th><th>Registration Number</th><th>Section</th><th>CGPA</th><th>Result</th></tr></thead>';
//     echo '<tbody>';

//     // Initialize a serial number counter
//     $serialNo = 1;

//     // Loop through the results to generate the table rows
//     foreach ($results as $row) {
//         echo '<tr>';
//         // Assign the serial number manually
//         echo '<td>' . $serialNo++ . '</td>';
//         echo "<td>{$row['student_name']}</td>";
//         echo "<td>{$row['registration_number']}</td>";
//         echo "<td>{$row['section']}</td>";
//         echo "<td>{$row['cgpa']}</td>";
//         echo "<td>{$row['overall_result']}</td>";
//         echo '</tr>';
//     }

//     echo '</tbody></table>';
// }
//  elseif ($reportType == 'fail') {
//     $results = array_filter($results, fn($r) => $r['overall_result'] == 'Fail');

//     // Fetch failed subjects in a single query
//     $ids = array_column($results, 'id');
//     $placeholders = str_repeat('?,', count($ids) - 1) . '?';

//     $stmt = $pdo->prepare("SELECT result_id, subject_name, grade 
//                            FROM subject_results 
//                            WHERE result_id IN ($placeholders) 
//                            AND (grade = 'F' OR grade = 'Absent')");
//     $stmt->execute($ids);
//     $subjectFailures = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);

//     // Display fail list
//     echo '<table class="table" id="failTable">';
//     echo '<thead><tr><th>Serial No.</th><th>Student Name</th><th>Registration Number</th><th>Section</th><th>CGPA</th><th>Result</th><th>Failed/Absent Subjects</th></tr></thead>';
//     echo '<tbody>';

//     $serialNo = 1;
//     foreach ($results as $row) {
//         echo '<tr>';
//         echo '<td>' . $serialNo++ . '</td>';
//         echo "<td>{$row['student_name']}</td>";
//         echo "<td>{$row['registration_number']}</td>";
//         echo "<td>{$row['section']}</td>";
//         echo "<td>{$row['cgpa']}</td>";
//         echo "<td>{$row['overall_result']}</td>";
//         echo '<td>';
//         if (isset($subjectFailures[$row['id']])) {
//             foreach ($subjectFailures[$row['id']] as $subject) {
//                 echo "{$subject['subject_name']} ({$subject['grade']})<br>";
//             }
//         } else {
//             echo "No failed or absent subjects";
//         }
//         echo '</td>';
//         echo '</tr>';
//     }
//     echo '</tbody></table>';

// } elseif ($reportType == 'subject_wise') {
//     // Fetch all subject data in a single query
//     $stmt = $pdo->prepare("SELECT sr.result_id, sr.subject_name, sr.grade, sr.grade_point, 
//                                   st.student_name, st.registration_number, st.section
//                            FROM subject_results sr 
//                            JOIN student_results st ON sr.result_id = st.id 
//                            WHERE st.semester = :semester");
//     $stmt->execute([':semester' => $semester]);
//     $subjectData = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);

//     echo '<table class="table" id="subjectWiseTable">';
//     echo '<thead><tr><th>Serial No.</th><th>Student Name</th><th>Registration Number</th><th>Section</th><th>Subject</th><th>Grade</th><th>Grade Point</th><th>Subject Result</th></tr></thead>';
//     echo '<tbody>';

//     $serialNo = 1;
//     foreach ($subjectData as $resultId => $subjects) {
//         foreach ($subjects as $subject) {
//             echo '<tr>';
//             echo '<td>' . $serialNo++ . '</td>';
//             echo "<td>{$subject['student_name']}</td>";
//             echo "<td>{$subject['registration_number']}</td>";
//             echo "<td>{$subject['section']}</td>";
//             echo "<td>{$subject['subject_name']}</td>";
//             echo "<td>{$subject['grade']}</td>";
//             echo "<td>{$subject['grade_point']}</td>";
//             $subjectResult = ($subject['grade'] === 'F' || strtoupper($subject['grade']) === 'ABSENT') ? 'Fail' : 'Pass';
//             echo "<td>{$subjectResult}</td>";
//             echo '</tr>';
//         }
//     }
//     echo '</tbody></table>';

// } elseif ($reportType == 'cgpa_list') {
//     usort($results, fn($a, $b) => $b['cgpa'] <=> $a['cgpa']);

//     echo '<table class="table" id="cgpaTable">';
//     echo '<thead><tr><th>Serial No.</th><th>Student Name</th><th>Registration Number</th><th>Section</th><th>CGPA</th><th>Result</th></tr></thead>';
//     echo '<tbody>';
//     foreach ($results as $index => $row) {
//         echo '<tr>';
//         echo '<td>' . ($index + 1) . '</td>';
//         echo "<td>{$row['student_name']}</td>";
//         echo "<td>{$row['registration_number']}</td>";
//         echo "<td>{$row['section']}</td>";
//         echo "<td>{$row['cgpa']}</td>";
//         echo "<td>{$row['overall_result']}</td>";
//         echo '</tr>';
//     }
//     echo '</tbody></table>';
// }
?>

<?php
// require './db/db.php';

// //$program = $_POST['program'];
// $semester = $_POST['semester'];
// $reportType = $_POST['reportType'];
// $section = isset($_POST['section']) ? $_POST['section'] : null;
// $subject = isset($_POST['subject']) ? $_POST['subject'] : null;


// $query = "SELECT id, student_name, registration_number, section, sgpa, cgpa, overall_result FROM student_results WHERE course = ? AND semester = ?";
// $params = [$program, $semester];


// if ($section) {
//     $query .= " AND section = ?";
//     $params[] = $section;
// }


// $stmt = $pdo->prepare($query);
// $stmt->execute($params);
// $results = $stmt->fetchAll(PDO::FETCH_ASSOC);



// <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
// <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
// <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>


// <script>
// function exportTableToCSV(tableID, filename) {
//     let csv = [];
//     let rows = document.querySelectorAll(`#${tableID} tr`);
    
//     for (let row of rows) {
//         let cols = row.querySelectorAll('td, th');
//         let rowArray = Array.from(cols).map(col => `"${col.innerText}"`);
//         csv.push(rowArray.join(','));
//     }

//     let csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
//     let downloadLink = document.createElement("a");
//     downloadLink.download = filename;
//     downloadLink.href = window.URL.createObjectURL(csvFile);
//     downloadLink.style.display = "none";
//     document.body.appendChild(downloadLink);
//     downloadLink.click();
//     document.body.removeChild(downloadLink);
// }

// function exportTableToExcel(tableID, filename) {
//     let table = document.getElementById(tableID);
//     let workbook = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});

    
//     setTimeout(() => {
//         XLSX.writeFile(workbook, filename);
//     }, 100);  
// }

// function exportTableToPDF(tableID, filename) {
//     const { jsPDF } = window.jspdf;
//     const doc = new jsPDF();


//     const table = document.getElementById(tableID);
//     const rows = [...table.querySelectorAll('tr')].map(tr => [...tr.querySelectorAll('th, td')].map(td => td.innerText));

   
//     setTimeout(() => {
//         doc.autoTable({
//             head: [rows[0]], 
//             body: rows.slice(1), 
//             styles: { fontSize: 10, halign: 'center' },
//         });
//         doc.save(filename);
//     }, 100);  

// function printTable(tableID) {
//     let table = document.getElementById(tableID);
//     if (!table) {
//         console.error("Table not found!");
//         return;
//     }
//     let printContents = table.outerHTML;
//     let originalContents = document.body.innerHTML;
//     document.body.innerHTML = printContents;
//     window.print();
//     document.body.innerHTML = originalContents;
//     window.location.reload(); 
// }

// </script>


// if ($reportType == 'pass') {
//     $results = array_filter($results, fn($r) => $r['overall_result'] == 'Pass');

    
//     echo '<table class="table" id="passTable">';
//     echo '<thead><tr><th>Serial No.</th><th>Student Name</th><th>Registration Number</th><th>Section</th><th>CGPA</th><th>Result</th></tr></thead>';
//     echo '<tbody>';
//     foreach ($results as $index => $row) {
//         echo '<tr>';
//         echo '<td>' . ($index + 1) . '</td>';
//         echo "<td>{$row['student_name']}</td>";
//         echo "<td>{$row['registration_number']}</td>";
//         echo "<td>{$row['section']}</td>";
//         echo "<td>{$row['cgpa']}</td>";
//         echo "<td>{$row['overall_result']}</td>";
//         echo '</tr>';
//     }
//     echo '</tbody></table>';

// } elseif ($reportType == 'fail') {
//     $results = array_filter($results, fn($r) => $r['overall_result'] == 'Fail');

//     foreach ($results as &$result) {
//         $stmt = $pdo->prepare("SELECT subject_name, grade FROM subject_results WHERE result_id = ? AND (grade = 'F' OR grade = 'Absent')");
//         $stmt->execute([$result['id']]);
//         $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

//         $result['subjects'] = $subjects;
//     }

    
//     echo '<table class="table" id="failTable">';
//     echo '<thead><tr><th>Serial No.</th><th>Student Name</th><th>Registration Number</th><th>Section</th><th>CGPA</th><th>Result</th><th>Failed/Absent Subjects</th></tr></thead>';
//     echo '<tbody>';

//     $serialNo = 1;
//     foreach ($results as $row) {
//         echo '<tr>';
//         echo '<td>' . $serialNo++ . '</td>';
//         echo "<td>{$row['student_name']}</td>";
//         echo "<td>{$row['registration_number']}</td>";
//         echo "<td>{$row['section']}</td>";
//         echo "<td>{$row['cgpa']}</td>";
//         echo "<td>{$row['overall_result']}</td>";
//         echo '<td>';
//         if (!empty($row['subjects'])) {
//             foreach ($row['subjects'] as $subject) {
//                 echo "{$subject['subject_name']} ({$subject['grade']})<br>";
//             }
//         } else {
//             echo "No failed or absent subjects";
//         }
//         echo '</td>';
//         echo '</tr>';
//     }
//     echo '</tbody></table>';

// } elseif ($reportType == 'subject_wise') {
//     $stmt = $pdo->prepare("SELECT DISTINCT subject_name FROM subject_results WHERE result_id IN (SELECT id FROM student_results WHERE semester = ?)");
//     $stmt->execute([$semester]);
//     $subjectList = $stmt->fetchAll(PDO::FETCH_COLUMN);
//     echo '<table class="table" id="subjectWiseTable">';
// echo '<thead><tr><th>Serial No.</th><th>Student Name</th><th>Registration Number</th><th>Section</th><th>Subject</th><th>Grade</th><th>Grade Point</th><th>Subject Result</th></tr></thead>';
// echo '<tbody>';

// $serialNo = 1;
// foreach ($subjectList as $subjectName) {
//     foreach ($results as $row) {
//         $stmt = $pdo->prepare("SELECT grade, grade_point FROM subject_results WHERE result_id = ? AND subject_name = ?");
//         $stmt->execute([$row['id'], $subjectName]);
//         $subjectData = $stmt->fetch(PDO::FETCH_ASSOC);

        
//         if ($subjectData) {
//             echo '<tr>';
//             echo '<td>' . $serialNo++ . '</td>';
//             echo "<td>{$row['student_name']}</td>";
//             echo "<td>{$row['registration_number']}</td>";
//             echo "<td>{$row['section']}</td>";
//             echo "<td>{$subjectName}</td>";
//             echo "<td>{$subjectData['grade']}</td>";
//             echo "<td>{$subjectData['grade_point']}</td>";
//             $subjectResult = ($subjectData['grade'] === 'F' || strtoupper($subjectData['grade']) === 'ABSENT') ? 'Fail' : 'Pass';
//             echo "<td>{$subjectResult}</td>";
//             echo '</tr>';
//         }
//     }
//     echo '<tr><td colspan="8" style="height: 10px;"></td></tr>';

// }
// echo '</tbody></table>';


// } elseif ($reportType == 'cgpa_list') {
//     usort($results, fn($a, $b) => $b['cgpa'] <=> $a['cgpa']);

//     echo '<table class="table" id="cgpaTable">';
//     echo '<thead><tr><th>Serial No.</th><th>Student Name</th><th>Registration Number</th><th>Section</th><th>CGPA</th><th>Result</th></tr></thead>';
//     echo '<tbody>';
//     foreach ($results as $index => $row) {
//         echo '<tr>';
//         echo '<td>' . ($index + 1) . '</td>';
//         echo "<td>{$row['student_name']}</td>";
//         echo "<td>{$row['registration_number']}</td>";
//         echo "<td>{$row['section']}</td>";
//         echo "<td>{$row['cgpa']}</td>";
//         echo "<td>{$row['overall_result']}</td>";
//         echo '</tr>';
//     }
//     echo '</tbody></table>';
// } 
