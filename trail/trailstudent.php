
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student Dashboard</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="./trail.css">
  </head>
  <body>

  <!-- Navigation Bar -->
  <nav class="navbar custom-navbar">
    <a class="navbar-brand" href="#">SOA</a>
    <button class="btn logout-btn" onclick="window.location.href='./logout.php'">Logout</button>
  </nav>

  <br/><br/><br/><br/>

  <!-- Form for Student Info -->
  <form id="student-form">
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
        <!-- Options A to H -->
        <?php
          foreach (range('A', 'H') as $section) {
            echo "<option value='$section'>$section</option>";
          }
        ?>
      </select>
    </div>
    <br/><br/><br/><br/>
    <div class="form-group submit-button">
      <button type="button" class="btn btn-primary" onclick="submitForm()">Next</button>
    </div>
  </form>

  <!-- Placeholder for dynamic table -->
  <div id="dynamic-table"></div>

  <!-- Modal Structure -->
  <div id="modal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <h2>Add Result</h2>
    <div id="modal-header"></div> <!-- Holds the form data -->
    <div id="modal-table"></div>
    <div class="modal-footer">
      <button type="button" class="btn btn-success" onclick="submitTable()">Submit</button>
      <button type="button" class="btn btn-danger" onclick="closeModal()">Cancel</button>
    </div>
  </div>

  <!-- Placeholder for dynamically generated cards -->
  <div id="cardContainer"></div>

  <!-- Modal for displaying card details -->
  <div id="modal1" class="modal">
  <span class="close" onclick="toggleModal('modal1', false)">&times;</span>

    <h2>Submitted Results</h2>
    <div id="modal1-table"></div>
  </div>

  <script>
    // Show semesters based on selected program
function showSemesters() {
    const program = document.getElementById('program').value;
    const semester = document.getElementById('semester');
    semester.innerHTML = ''; // Clear existing options
    const maxSemesters = program === 'MCA' ? 4 : 6;
    for (let i = 1; i <= maxSemesters; i++) {
        semester.innerHTML += `<option value="${i}">Semester ${i}</option>`;
    }
}

// Function to open/close modal
function toggleModal(modalId, state) {
    document.getElementById(modalId).style.display = state ? "block" : "none";
}

// Close modal function
function closeModal() {
    toggleModal('modal', false);
}

// Close modal1 function
function closeModal1() {
    toggleModal('modal1', false);
}

// Handle form submission and open modal
function submitForm() {
    const fields = ['program', 'semester', 'registration', 'student-name', 'section'];
    const isValid = fields.every(field => document.getElementById(field).value);

    if (!isValid) {
        alert('Please fill all fields.');
        return;
    }
// Fetch the form values
const program = document.getElementById('program').value;
    const semester = document.getElementById('semester').value;
    const registration = document.getElementById('registration').value;
    const studentName = document.getElementById('student-name').value;
    const section = document.getElementById('section').value;

    // Display the form data in the modal header
    document.getElementById('modal-header').innerHTML = `
        <p><strong>Program:</strong> ${program}</p>
        <p><strong>Semester:</strong> ${semester}</p>
        <p><strong>Registration No:</strong> ${registration}</p>
        <p><strong>Name:</strong> ${studentName}</p>
        <p><strong>Section:</strong> ${section}</p>
    `;
    // Open modal and fetch subjects
    toggleModal('modal', true);
    $.ajax({
        url: './fetch_subjects2.php',
        method: 'POST',
        data: {
            program: document.getElementById('program').value,
            semester: document.getElementById('semester').value
        },
        success(response) {
            document.getElementById('modal-table').innerHTML = response;
        },
        error() {
            alert('Error fetching subjects.');
        }
    });
}

// Function to validate form inputs
function validateForm(sgpa, cgpa, result, allGradesValid) {
    if (!sgpa || !cgpa || !result || !allGradesValid) {
        alert('Please fill all the fields (including Grade, Grade Point, SGPA, CGPA, and Overall Result).');
        return false;
    }
    if (parseFloat(sgpa) > 10 || parseFloat(cgpa) > 10) {
        alert('SGPA and CGPA should be between 0.000 and 10.000.');
        return false;
    }
    return true;
}

// Function to update grade point based on selected grade
function updateGradePoint(gradeSelect, gradePointInput) {
    const gradeMapping = {
        "A++": 10,
        "A": 9,
        "B": 8,
        "C": 7,
        "D": 6,
        "E": 5,
        "F": 0,
        "ABSENT": 0
    };

    // Get the default grade point value based on the selected grade
    const defaultGradePoint = gradeMapping[gradeSelect.value] || 0;

    // Set the input field to the default grade point, formatted to 2 decimal places
    gradePointInput.value = defaultGradePoint.toFixed(2);

    // Disable editing of the whole number and allow editing only the decimal part
    gradePointInput.addEventListener('keydown', function(event) {
        const caretPosition = gradePointInput.selectionStart;
        const valueBeforeDecimal = gradePointInput.value.indexOf('.');

        // Prevent modification of the whole number part
        if (caretPosition <= valueBeforeDecimal) {
            event.preventDefault();
        }
    });

    // Allow manual adjustment with validation for up to 2 decimal places
    gradePointInput.addEventListener('input', function() {
        const regex = /^\d+(\.\d{0,2})?$/;
        if (!regex.test(gradePointInput.value)) {
            gradePointInput.value = gradePointInput.value.slice(0, -1);
        }
    });
}

// Submit modal form and create card
function submitTable() {
    const sgpa = document.getElementById('sgpa-input').value;
    const cgpa = document.getElementById('cgpa-input').value;
    const result = document.getElementById('result').value;
    const subjects = [];

    let allGradesValid = true;
    document.querySelectorAll('tbody tr').forEach((row, index) => {
        const subjectName = row.querySelector('td:nth-child(2)').textContent;
        const credits = row.querySelector('td:nth-child(3)').textContent;
        const gradeElement = row.querySelector('td:nth-child(4) select');
        const gradePointElement = row.querySelector('td:nth-child(5) input');

        const grade = gradeElement ? gradeElement.value : null;
        const gradePoint = gradePointElement ? gradePointElement.value : null;

        if (!grade || !gradePoint) allGradesValid = false;

        subjects.push({
            serial_no: index + 1,
            subject_name: subjectName,
            credits: credits,
            grade: grade,
            grade_point: gradePoint
        });
    });

    if (!validateForm(sgpa, cgpa, result, allGradesValid)) return;

    // Create card if form is valid
    createCard(subjects, sgpa, cgpa, result);
    alert('Form is valid and ready for submission.');
    toggleModal('modal', false);
}

// Create a card with the submitted data
function createCard(subjects, sgpa, cgpa, result) {
    const cardContainer = document.getElementById("cardContainer");

    const card = document.createElement("div");
    card.className = "card";
    card.innerHTML = `
        <h3>Student Results</h3>
        <p><strong>SGPA:</strong> ${sgpa}</p>
        <p><strong>CGPA:</strong> ${cgpa}</p>
        <p><strong>Overall Result:</strong> ${result}</p>
        <h4>Click to view details</h4>
    `;
    card.onclick = () => openModalWithTable1(subjects, sgpa, cgpa);
    cardContainer.appendChild(card);
}

// Open modal1 with table data
function openModalWithTable1(subjects, sgpa, cgpa) {
    // Fetch the form values again
    const program = document.getElementById('program').value;
    const semester = document.getElementById('semester').value;
    const registration = document.getElementById('registration').value;
    const studentName = document.getElementById('student-name').value;
    const section = document.getElementById('section').value;
    const tableContent = subjects.map(subject => `
        <tr>
            <td>${subject.serial_no}</td>
            <td>${subject.subject_name}</td>
            <td>${subject.credits}</td>
            <td>${subject.grade}</td>
            <td>${subject.grade_point}</td>
        </tr>
    `).join('');

    document.getElementById('modal1-table').innerHTML = `
    <div id="modal1-header">
            <p><strong>Program:</strong> ${program}</p>
            <p><strong>Semester:</strong> ${semester}</p>
            <p><strong>Registration No:</strong> ${registration}</p>
            <p><strong>Name:</strong> ${studentName}</p>
            <p><strong>Section:</strong> ${section}</p>
        </div>
        <table class="table">
            <thead>
                <tr><th>Serial No.</th><th>Subject Name</th><th>Credits</th><th>Grade</th><th>Grade Point</th></tr>
            </thead>
            <tbody>${tableContent}</tbody>
        </table>
        <div class="sgpa-cgpa-section">
            <p><strong>SGPA:</strong> ${sgpa}</p>
            <p><strong>CGPA:</strong> ${cgpa}</p>
        </div>
    `;
    toggleModal('modal1', true);
}

// Toggle modal and blur background
function toggleModal(modalId, state) {
    document.getElementById(modalId).style.display = state ? "block" : "none";
    document.body.classList.toggle('modal-active', state);
}

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target == document.getElementById("modal")) {
        toggleModal('modal', false);
    }
    if (event.target == document.getElementById("modal1")) {
        toggleModal('modal1', false);
    }
};


  </script>
  </body>
</html>
