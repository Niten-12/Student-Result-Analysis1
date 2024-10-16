<?php
session_start();
require './db/db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'login') {
        $registration_number = $_POST['loginUsername'];
        $password = md5($_POST['loginPassword']); // Hash the password

        // Prepare SQL statement to avoid SQL injection
        $stmt = $pdo->prepare('SELECT * FROM users WHERE registration_number = ? AND password = ?');
        $stmt->execute([$registration_number, $password]);
        $user = $stmt->fetch();

        if ($user) {
            // Set session for the logged-in user
            $_SESSION['user'] = $user['registration_number'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on user role
            if ($user['role'] == 'admin') {
                header('Location: admindashboard.php');
            } else {
                header('Location: studentdashboard.php');
            }
        } else {
            $loginError = "Invalid login credentials. Please try again.";
        }
    }

    if ($action == 'signup') {
        $registration_number = $_POST['newUser'];
        $password = md5($_POST['newPassword']); // Hash the password

        // Check if the registration number is already in use
        $stmt = $pdo->prepare('SELECT * FROM users WHERE registration_number = ?');
        $stmt->execute([$registration_number]);
        
        if ($stmt->rowCount() == 0) {
            // Insert new student record into the database
            $stmt = $pdo->prepare('INSERT INTO users (registration_number, password, role) VALUES (?, ?, "student")');
            $stmt->execute([$registration_number, $password]);
            $signupSuccess = "Sign-up successful! Redirecting...";
            echo "<script>setTimeout(function(){ window.location.href = 'studentdashboard.php'; }, 1500);</script>";
        } else {
            $signupError = "Registration number already exists.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SOA | Login and Sign-up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
      /* Consistent Error Styling */
      :root {
        --error-color: red;
      }

      body,
      html {
        height: 100%;
      }

      .background-blue {
        background-color: #0047ab;
      }

      .background-gray {
        background-color: #88b3d8;
        padding: 0 20px;
      }

      .btn-custom {
        background-color: white;
        border-radius: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.7);
        transition: background-color 0.3s ease, color 0.3s ease;
        color: black;
        margin-right: 10px;
      }

      .btn-custom:hover {
        background-color: #d3d3d3;
        color: #000000;
      }

      .footer-buttons {
        position: fixed;
        bottom: 20px;
        left: 190px;
      }

      .footer-right {
        position: fixed;
        bottom: 20px;
        right: 220px;
        color: black;
      }

      .error {
        color: var(--error-color);
        margin-top: 10px;
      }

      .strength-meter {
        height: 5px;
        background-color: red;
        margin-top: 5px;
        border-radius: 5px;
        transition: width 0.5s;
      }

      .success-message {
        color: green;
        margin-top: 15px;
        display: none;
      }

      /* Enhanced Mobile Responsiveness */
      @media (max-width: 768px) {
        .footer-buttons {
          left: 10px;
        }

        .footer-right {
          right: 10px;
        }

        .btn-custom {
          margin-bottom: 10px;
        }
      }
    </style>
  </head>
  <body>
    <div class="container-fluid h-100">
      <div class="row h-100">
        <div class="col-md-6 background-blue d-flex flex-column justify-content-center align-items-center text-white">
          <h1>SOA | SIKSHA 'O' ANUSANDHAN</h1>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-center">
          <div class="w-75">
            <div id="formContent">
              <!-- Tabs Titles -->
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" id="login-tab" data-bs-toggle="tab" href="#login">Login</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="signup-tab" data-bs-toggle="tab" href="#signup">Sign up</a>
                </li>
              </ul>

              <div class="tab-content">
                <!-- Login Form -->
                <div class="tab-pane fade show active" id="login">
                  <form method="post" action="./index.php">
                    <input type="hidden" name="action" value="login" />
                    <input type="text" name="loginUsername" class="form-control mt-3" placeholder="Registration Number or Username" required />
                    <input type="password" name="loginPassword" class="form-control mt-3" placeholder="Password" required />
                    <input type="submit" class="btn btn-primary mt-3 w-100" value="Sign In" />
                    <a href="#" class="btn btn-link" id="forgotPasswordLink">Forgot Password?</a>
                    <?php if (isset($loginError)): ?>
                      <div class="error"><?php echo $loginError; ?></div>
                    <?php endif; ?>
                  </form>
                </div>

                <!-- Sign Up Form -->
                <div class="tab-pane fade" id="signup">
                  <form method="post" action="./index.php">
                    <input type="hidden" name="action" value="signup" />
                    <input type="text" name="newUser" class="form-control mt-3" placeholder="Registration Number" required />
                    <input type="password" name="newPassword" id="newPassword" class="form-control mt-3" placeholder="New Password" oninput="checkPasswordStrength()" required />
                    <div id="strengthMeter" class="strength-meter"></div>
                    <input type="password" name="confirmPassword" id="confirmPassword" class="form-control mt-3" placeholder="Confirm Password" required />
                    <?php if (isset($signupError)): ?>
                      <div class="error"><?php echo $signupError; ?></div>
                    <?php endif; ?>
                    <input type="submit" class="btn btn-primary mt-3 w-100" value="Sign Up" />
                    <?php if (isset($signupSuccess)): ?>
                      <div class="success-message"><?php echo $signupSuccess; ?></div>
                    <?php endif; ?>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Bottom Navbar -->
      <div class="footer-buttons">
        <button class="btn btn-custom">Contact SOA</button>
        <button class="btn btn-custom" onclick="showAdminLogin()">Admin</button>
      </div>
      <div class="footer-right">
        <span>© 2024 SOA. All rights reserved.</span>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      function showAdminLogin() {
        document.getElementById("signup-tab").classList.add("d-none");
        document.getElementById("login-tab").click();
        document.getElementById("forgotPasswordLink").style.display = "none";
      }

      function checkPasswordStrength() {
        const password = document.getElementById("newPassword").value;
        const strengthMeter = document.getElementById("strengthMeter");
        let strength = 0;

        if (password.length >= 8) strength += 25;
        if (/[A-Z]/.test(password)) strength += 25;
        if (/[0-9]/.test(password)) strength += 25;
        if (/[@$!%*?&#]/.test(password)) strength += 25;

        strengthMeter.style.width = strength + "%";
        if (strength === 100) {
          strengthMeter.style.backgroundColor = "green";
        } else if (strength >= 50) {
          strengthMeter.style.backgroundColor = "orange";
        } else {
          strengthMeter.style.backgroundColor = "red";
        }
      }
    </script>
  </body>
</html>
