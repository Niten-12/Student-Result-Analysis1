<?php 
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header('Location: index.php');
    exit();
}

// Security Enhancement: Regenerate session ID to prevent session fixation attacks
session_regenerate_id(true);

// Generate a CSRF token to prevent CSRF attacks
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery and DataTables -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Buttons extension -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>

    <!-- JSZip for Excel export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>

    <!-- pdfmake for PDF export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    <!-- DataTables Buttons Print -->
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    
    <link rel="stylesheet" href="./css/admin_dash.css" />
</head>
<body>
<nav class="navbar custom-navbar fixed-top">
  <a class="navbar-brand" href="#">SOA</a>
  <button class="btn logout-btn" onclick="window.location.href='./logout.php'">Logout</button>
</nav>
<br/>
<br/>
<br/>
<br/>

<div class="container mt-5">
<h2 style="text-align: center;">Admin Dashboard</h2>

<div style="text-align: center;">
    <button class="btn btn-primary" id="generateReportBtn">Generate Report</button>
</div>


    <!-- Report Form -->
    <div id="reportFormContainer" class="mt-4" style="display: none;">
        <form id="reportForm" onsubmit="fetchReport(); return false;">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>" />
            
            <!-- Program Selection -->
            <div class="form-group">
                <label for="program">Program</label>
                <select class="form-control" id="program" name="program" required>
                    <option value="">Select Program</option>
                    <option value="BCA">BCA</option>
                    <option value="MCA">MCA</option>
                </select>
            </div>

            <!-- Semester Selection -->
            <div class="form-group">
                <label for="semester">Semester</label>
                <select class="form-control" id="semester" name="semester" required>
                    <option value="">Select Semester</option>
                </select>
            </div>

            <!-- Year Selection (with automatic navigation) -->
        <div class="form-group">
            <label for="year">Year</label>
            <input type="text" list="yearList" id="year" name="year" class="form-control" required placeholder="Enter year">
            <datalist id="yearList">
                <!-- Generate years from 2001 to 2100 -->
                <?php
                for ($year = 2001; $year <= 2100; $year++) {
                    echo "<option value=\"$year\">$year</option>";
                }
                ?>
            </datalist>
        </div>

        <!-- Month Selection -->
        <div class="form-group">
            <label for="month">Month</label>
            <select class="form-control" id="month" name="month" required>
                <option value="">Select Month</option>
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
            </select>
        </div>

            <!-- Report Type Selection -->
            <div class="form-group">
                <label for="reportType">Report Type</label>
                <select class="form-control" id="reportType" name="reportType" required>
                    <option value="">Select Report Type</option>
                    <option value="pass">Pass List</option>
                    <option value="fail">Fail List</option>
                    <option value="subject_wise">Subject Wise Grade List</option>
                    <option value="cgpa_list">CGPA List</option>
                </select>
            </div>

            <!-- Optional Section Selection -->
            <div class="form-group">
                <label for="section">Section (Optional)</label>
                <select class="form-control" id="section" name="section">
                    <option value="">Select Section</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
            </div>

            <!-- Optional Subject Selection -->
            <div class="form-group">
                <label for="subject">Subject (Optional)</label>
                <select class="form-control" id="subject" name="subject">
                    <option value="">Select Subject</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
    <!-- <div id="cgpaFilterContainer" style="display:none;">
    <label for="cgpaFilter">Filter by CGPA:</label>
    <select id="cgpaFilter" class="form-control" style="width: auto; display: inline-block;">
        <option value="">Select CGPA</option>
        <option value="6">Above 6.0</option>
        <option value="7">Above 7.0</option>
        <option value="8">Above 8.0</option>
        <option value="9">Above 9.0</option>
    </select>
</div> -->

    <!-- Display Report Results -->
    <div id="reportResults" class="mt-4"></div>
    
</div>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
<!-- Add Footer Navigation -->
<footer class="footer bg-light mt-5">
  <div class="container">
    <div class="row">
      <!-- Left Section with Buttons -->
      <div class="col-md-6 text-left">
        <button class="btn btn-outline-dark mr-2" id="contactSOA">Contact SOA</button>
      </div>

      <!-- Right Section with Copyright Text -->
      <div class="col-md-6 text-right">
        <p class="mb-0">&copy; <?php echo date('Y'); ?> SOA. All rights reserved.</p>
      </div>
    </div>
  </div>
</footer>


<script>
$(document).ready(function() {
    // Toggle report form visibility
    $('#generateReportBtn').click(function() {
        $('#reportFormContainer').toggle();
    });

    // Load semesters based on selected program
    $('#program').change(function() {
        var program = $(this).val();
        var semesters = (program === 'BCA') ? 6 : 4;
        var semesterOptions = '<option value="">Select Semester</option>';
        for (var i = 1; i <= semesters; i++) {
            semesterOptions += '<option value="' + i + '">Semester ' + i + '</option>';
        }
        $('#semester').html(semesterOptions);
    });

    // Load subjects based on selected program and semester
    $('#semester').change(function() {
        var program = $('#program').val();
        var semester = $(this).val();
        if (program && semester) {
            $.ajax({
                url: './fetch_subjects1.php',
                method: 'POST',
                data: { program: program, semester: semester },
                success: function(response) {
                    $('#subject').html(response);
                }
            });
        }
    });
});

// Function to fetch the report and display it
function fetchReport() {
    var program = $('#program').val();
    var semester = $('#semester').val();
    var reportType = $('#reportType').val();
    var section = $('#section').val();
    var subject = $('#subject').val();
    var csrfToken = $('input[name="csrf_token"]').val();

    if (program && semester && reportType && csrfToken) {
        $.ajax({
            url: './fetch_report.php',
            method: 'POST',
            data: {
                program: program,
                semester: semester,
                reportType: reportType,
                section: section,
                subject: subject,
                csrf_token: csrfToken // Include CSRF token
            },
            success: function(data) {
                $('#reportResults').html(data); // Display the report data

                // Ensure the generated table has the id "reportTable"
                $('#reportResults table').attr('id', 'reportTable');

                // Re-initialize DataTable with export and print options after the table is rendered
                if ($('#reportTable').length) {
                    initDataTable();  // Call the function to initialize DataTable
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error fetching the report: ' + errorThrown);
            }
        });
    } else {
        alert('Please fill all required fields.');
    }
}

// Function to initialize DataTable with export buttons
// Function to initialize DataTable with export buttons
function initDataTable() {
    var table = $('#reportTable');
    
    // Ensure the table exists before applying DataTables
    if (table.length && $.fn.DataTable) {
        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable('#reportTable')) {
            $('#reportTable').DataTable().clear().destroy();  // Destroy the existing DataTable instance
        }

        // Get values from the form to use in the export header
        var program = $('#program').val();
        var semester = $('#semester').val();
        var year = $('#year').val();
        var month = $('#month').val();
        var reportType = $('#reportType').val();
        
        var exportTitle = `Program: ${program}, Semester: ${semester}, Year: ${year}, Month: ${month}, Report Type: ${reportType}`;

        // Get current date and time for footer
        var currentDate = new Date();
        var exportDate = currentDate.toLocaleDateString();
        var exportTime = currentDate.toLocaleTimeString();

        // Initialize DataTable with export options
        var dataTable = $('#reportTable').DataTable({
            dom: 'Bfrtip',  // B - buttons, f - filter, r - processing, t - table, i - info, p - pagination
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export CSV',
                    title: exportTitle,
                    className: 'btn btn-success',
                    customize: function (csv) {
                        return csv + `\nExported on: ${exportDate} at ${exportTime}`;  // Add footer with date and time
                    }
                },
                {
                    extend: 'excel',
                    text: 'Export Excel',
                    title: exportTitle,
                    className: 'btn btn-info',
                    exportOptions: {
                        columns: ':visible'  // Optionally, export only visible columns
                    }
                },
                {
                    extend: 'pdf',
                    text: 'Export PDF',
                    className: 'btn btn-warning',
                    orientation: 'landscape',  // Adjust layout to fit data
                    pageSize: 'A4',
                    title: exportTitle,
                    customize: function (doc) {
                        // Custom header with report details
                        doc.content.splice(0, 1, {
                            text: exportTitle,
                            fontSize: 12,
                            alignment: 'center',
                            margin: [0, 0, 0, 20]  // Adjust margin to add space between title and table
                        });

                        // Add export date and time at the bottom in small text
                        doc['footer'] = function (currentPage, pageCount) {
                            return {
                                text: `Exported on: ${exportDate} at ${exportTime}`,
                                alignment: 'right',
                                fontSize: 8,  // Small font size
                                margin: [0, 10, 20, 0]
                            };
                        };
                    }
                },
                {
                    extend: 'print',
                    text: 'Print Table',
                    title: exportTitle,
                    className: 'btn btn-primary',
                    customize: function (win) {
                        // Add the date and time to the footer in the print view
                        $(win.document.body).append(
                            `<div style="text-align:right; font-size:10px;">
                                Exported on: ${exportDate} at ${exportTime}
                             </div>`
                        );
                    }
                }
            ]
        });

        // Show CGPA filter only for 'Pass List' and 'CGPA List'
        if (reportType === 'pass' || reportType === 'cgpa_list') {
            $('#cgpaFilterContainer').hide();  // Hide original container

            // Insert the CGPA filter next to the search box
            $('.dataTables_filter').prepend(
                `
                <label for="customCGPA" style="margin-left: 10px;">Enter  CGPA:</label>
                <input type="number" id="customCGPA" min="0" max="10" step="0.01" class="form-control" style="width: 100px; display: inline-block; margin-left: 10px;">`
            );

            // Apply the CGPA filter
            $('#cgpaFilter, #customCGPA').on('change', function () {
                var selectedCGPA = parseFloat($('#cgpaFilter').val());
                var customCGPA = parseFloat($('#customCGPA').val());
                
                // Clear any previous custom filtering
                $.fn.dataTable.ext.search.pop();

                if (!isNaN(customCGPA)) {
                    // Custom filter to show rows with CGPA above the custom entered value
                    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                        var cgpa = parseFloat(data[4]);  // Assuming CGPA is in the 5th column (index 4)
                        return !isNaN(cgpa) && cgpa > customCGPA;
                    });
                } else if (!isNaN(selectedCGPA)) {
                    // Custom filter to show rows with CGPA above the selected dropdown value
                    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                        var cgpa = parseFloat(data[4]);  // Assuming CGPA is in the 5th column (index 4)
                        return !isNaN(cgpa) && cgpa > selectedCGPA;
                    });
                }

                dataTable.draw(); // Redraw the table with the custom filter applied
            });
        } else {
            $('#cgpaFilterContainer').hide();  // Hide the CGPA filter if it's not 'Pass List' or 'CGPA List'
        }
    } else {
        console.error("DataTable plugin not loaded or table does not exist.");
    }
}



</script>

</body>
</html>
