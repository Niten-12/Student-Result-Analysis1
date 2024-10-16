<?php
//studentdashboard.php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'student') {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student Dashboard</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="./css/studentcss.css">
  </head>
  <body>

  <!-- Navigation Bar -->
<nav class="navbar custom-navbar">
  <a class="navbar-brand" href="#">SOA</a>
  <button class="btn logout-btn" onclick="window.location.href='./logout.php'">Logout</button>
</nav>
<br/>
<br/>
<br/>
<br/>
<h1>Welcome, <?php echo $_SESSION['user']; ?>!</h1>

<!-- Form for Student Info -->
<form id="student-form">
  <!-- Form remains fixed -->
  <div class="form-group">
    <label for="program">Program:</label>
    <select id="program" class="form-control" onchange="showSemesters()" required>
      <option value="">Select</option>
      <option value="BCA">BCA</option>
      <option value="MCA">MCA</option>
    </select>
  </div>
  <div class="form-group">
    <label for="semester">Semester:</label>
    <select id="semester" class="form-control" required></select>
  </div>
  <div class="form-group">
    <label for="registration">Reg No:</label>
    <input type="text" id="registration" class="form-control" required>
  </div>
  <div class="form-group">
    <label for="student-name">Name:</label>
    <input type="text" id="student-name" class="form-control" required>
  </div>
  <div class="form-group">
    <label for="section">Section:</label>
    <select id="section" class="form-control" required>
      <option value="">Select</option>
      <option value="A">A</option>
      <option value="B">B</option>
      <option value="C">C</option>
      <option value="D">D</option>
      <option value="E">E</option>
      <option value="F">F</option>
      <option value="G">G</option>
      <option value="H">H</option>
    </select>
  </div>
  <br><br><br><br>
  <div class="form-group submit-button">
    <button type="button" class="btn btn-primary" onclick="submitForm()">Next</button>
  </div>
</form>

<!-- Placeholder for dynamic table -->
<div id="dynamic-table"></div>

<!-- Modal Structure -->
<div id="modal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h2>Review Your Details</h2>
    <div id="modal-table"></div> <!-- Subject table inside modal -->
    <div class="modal-footer">
      <button type="button" class="btn btn-success" onclick="submitTable()">Submit</button>
      <button type="button" class="btn btn-danger" onclick="closeModal()">Cancel</button>
    </div>
  </div>
</div>

<script>
  function showSemesters() {
    const program = document.getElementById('program').value;
    const semester = document.getElementById('semester');
    semester.innerHTML = '';
    let maxSemesters = program === 'MCA' ? 4 : 6;
    for (let i = 1; i <= maxSemesters; i++) {
      semester.innerHTML += `<option value="${i}">Semester ${i}</option>`;
    }
  }

  // Show the modal when "Next" is clicked
  function submitForm() {
  const program = document.getElementById('program').value;
  const semester = document.getElementById('semester').value;
  const registration = document.getElementById('registration').value;
  const studentName = document.getElementById('student-name').value;
  const section = document.getElementById('section').value;

  if (program && semester && registration && studentName && section) {
    $.ajax({
      url: './fetch_subjects.php',
      type: 'POST',
      data: { program, semester },
      success: function(data) {
        if (data.trim() !== '') {
          $('#modal-table').html(`
            <div>
              <strong>Student Name:</strong> ${studentName} |
              <strong>Reg No:</strong> ${registration} |
              <strong>Section:</strong> ${section} |
              <strong>Course:</strong> ${program} |
              <strong>Semester:</strong> ${semester}
            </div>
            ${data}
          `);
          showModal();
        } else {
          alert('No subjects found for the selected program and semester.');
        }
      },
      error: function() {
        alert('Error fetching subjects.');
      }
    });
  } else {
    alert('Please fill all fields!');
  }
}

function showModal() {
  const modal = document.getElementById('modal');
  if ($('#modal-table').html().trim() !== '') {  // Ensure modal content is not empty
    modal.style.display = 'flex';
  }
}

  
  // Function to close the modal
  function closeModal() {
    const modal = document.getElementById('modal');
    $('#modal-table').html('');  // Clear modal content
    modal.style.display = 'none';  // Hide the modal

    // Optionally reset the form if you want
    document.getElementById('student-form').reset();
    document.getElementById('dynamic-table').innerHTML = '';  // Clear the table after submission
}



  // function closeModal() {
  //   const modal = document.getElementById('modal');
  //   modal.style.display = 'none';  // Hides the modal
  //   console.log("Modal closed.");
  // }

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

    // Ensure all required fields are filled
    if (sgpa && cgpa && result && subjects.length > 0) {
        if (parseFloat(sgpa) <= 10 && parseFloat(cgpa) <= 10) {
            // Perform AJAX request to save the data
            $.ajax({
                url: './save_results.php',
                method: 'POST',
                contentType: 'application/json',
                cache: false, // Disable cache
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
                    // Fast handling of the response
                    const parsedResponse = JSON.parse(response);
                    console.log(parsedResponse);  // Log the response to the console for debugging

                    if (parsedResponse.status === 'success') {
                        alert('Form submitted successfully!');
                        closeModal();  // Automatically close modal after clicking OK on alert
                        // Start auto-refresh every 3 seconds
                        setInterval(function() {
                            location.reload();  // Refresh the page
                        }, 3000);  // 3000 ms = 3 seconds
                    } else {
                        alert('Error: ' + parsedResponse.message);
                    }
                },
                error: function() {
                    alert('There was an error saving the data.');
                }
            });
        } else {
            alert('SGPA and CGPA should be between 0.000 and 10.000.');
        }
    } else {
        alert('Please fill all fields correctly and ensure subjects are added.');
    }
}


</script>

  </body>
</html>
