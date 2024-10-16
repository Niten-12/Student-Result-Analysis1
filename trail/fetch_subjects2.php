<?php 
// fetch_subjects.php
require '../db/db.php'; 

$program = $_POST['program'];  // Course/Program like 'MCA'
$semester = $_POST['semester'];

// Query to fetch subjects based on the normalized course structure
$stmt = $pdo->prepare('
    SELECT s.subject_name, s.credits 
    FROM subjects s 
    JOIN courses c ON s.course_id = c.id 
    WHERE c.course_program = ? AND s.semester = ?
');
$stmt->execute([$program, $semester]);
$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Begin Table Structure
echo '<table class="table">';
echo '<thead>';
echo '<tr><th>Serial No.</th><th>Subject Name</th><th>Credits</th><th>Grade</th><th>Grade Point</th></tr>';
echo '</thead>';
echo '<tbody>';

$serial = 1;
foreach ($subjects as $subject) {
    echo '<tr>';
    echo "<td>{$serial}</td>";
    echo "<td>{$subject['subject_name']}</td>";
    echo "<td>{$subject['credits']}</td>";

    // Grade dropdown (with onchange event to update grade point)
    echo '<td><select class="form-control grade-dropdown" onchange="updateGradePoint(this, this.parentElement.nextElementSibling.querySelector(\'input\'))">';
    echo '<option value="">Select Grade</option>';
    echo '<option value="A++">A++</option>';
    echo '<option value="A">A</option>';
    echo '<option value="B">B</option>';
    echo '<option value="C">C</option>';
    echo '<option value="D">D</option>';
    echo '<option value="E">E</option>';
    echo '<option value="F">F</option>';
    echo '<option value="ABSENT">ABSENT</option>';
    echo '</select></td>';

    // Grade point input field (with restriction to allow changing only the decimal part)
    echo '<td><input type="text" class="form-control grade-point" placeholder="0.00" pattern="^\d+(\.\d{0,2})?$" title="Enter valid Grade Point"></td>';
    
    echo '</tr>';
    $serial++;
}

echo '</tbody>';
echo '</table>';

// Insert SGPA, CGPA, and Overall Result form group here
echo '
<div class="form-group row">
  <div class="col-sm-4">
    <label for="sgpa-input">SGPA:</label>
    <input type="text" id="sgpa-input" class="form-control" placeholder="0.000" pattern="^\\d+(\\.\\d{1,3})?$" title="Enter valid SGPA (0.000 - 10.000)" required>
  </div>
  <div class="col-sm-4">
    <label for="cgpa-input">CGPA:</label>
    <input type="text" id="cgpa-input" class="form-control" placeholder="0.000" pattern="^\\d+(\\.\\d{1,3})?$" title="Enter valid CGPA (0.000 - 10.000)" required>
  </div>
  <div class="col-sm-4">
    <label for="result">Overall Semester Result:</label>
    <select id="result" class="form-control" required>
      <option value="">Select Result</option>
      <option value="Pass">Pass</option>
      <option value="Fail">Fail</option>
    </select>
  </div>
</div>';
?>

<script>
//Function to update grade point based on selected grade
// function updateGradePoint(gradeSelect, gradePointInput) {
//   const gradeMapping = {
//     "A++": 10,
//     "A": 9,
//     "B": 8,
//     "C": 7,
//     "D": 6,
//     "E": 5,
//     "F": 0,
//     "ABSENT": 0
//   };

//   // Get the default grade point value based on the selected grade
//   const defaultGradePoint = gradeMapping[gradeSelect.value] || 0;

//   // Set the input field to the default grade point, formatted to 2 decimal places
//   gradePointInput.value = defaultGradePoint.toFixed(2); 

//   // Disable editing of the whole number and allow editing only the decimal part
//   gradePointInput.addEventListener('keydown', function(event) {
//     const caretPosition = gradePointInput.selectionStart;
//     const valueBeforeDecimal = gradePointInput.value.indexOf('.');

//     // Prevent modification of the whole number part
//     if (caretPosition <= valueBeforeDecimal) {
//       event.preventDefault();
//     }
//   });

//   // Allow manual adjustment with validation for up to 2 decimal places
//   gradePointInput.addEventListener('input', function() {
//     const regex = /^\d+(\.\d{0,2})?$/;
//     if (!regex.test(gradePointInput.value)) {
//       gradePointInput.value = gradePointInput.value.slice(0, -1);
//     }
//   });
// }

// Function to submit the form with AJAX
function submitTable() {
  const sgpa = document.getElementById('sgpa-input').value;
  const cgpa = document.getElementById('cgpa-input').value;
  const result = document.getElementById('result').value;

  const studentName = document.getElementById('student-name').value;
  const registrationNumber = document.getElementById('registration').value;
  const section = document.getElementById('section').value;
  const course = document.getElementById('program').value;
  const semester = document.getElementById('semester').value;

  const subjects = [];
  document.querySelectorAll('tbody tr').forEach(row => {
    const subjectName = row.querySelector('td:nth-child(2)').textContent;
    const credits = row.querySelector('td:nth-child(3)').textContent;
    const grade = row.querySelector('td:nth-child(4) select').value;
    const gradePoint = row.querySelector('td:nth-child(5) input').value;

    subjects.push({
      subject_name: subjectName,
      credits: credits,
      grade: grade,
      grade_point: gradePoint
    });
  });

  if (sgpa && cgpa && result) {
    if (parseFloat(sgpa) <= 10 && parseFloat(cgpa) <= 10) {
      $.ajax({
        url: './save_results.php',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
          student_name: studentName,
          registration_number: registrationNumber,
          section: section,
          course: course,
          semester: semester,
          subjects: subjects,
          sgpa: sgpa,
          cgpa: cgpa,
          overall_result: result
        }),
        success: function(response) {
          alert('Form submitted successfully!');
        },
        error: function() {
          alert('There was an error saving the data.');
        }
      });
    } else {
      alert('SGPA and CGPA should be between 0.000 and 10.000.');
    }
  } else {
    alert('Please fill all fields correctly.');
  }
}

// Function to reset the form
function cancelTable() {
  document.getElementById('sgpa-input').value = '';
  document.getElementById('cgpa-input').value = '';
  document.getElementById('result').value = '';
  document.querySelectorAll('.grade-dropdown').forEach(select => select.value = '');
  document.querySelectorAll('.grade-point').forEach(input => input.value = '');
}
</script>