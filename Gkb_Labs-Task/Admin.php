

<?php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $adminUsername = $_POST['adminusername'];
        $adminPassword = $_POST['adminpassword'];
        
    // Connect to PostgreSQL database
    $host = 'localhost';
    $dbname = 'gkblabs';
    $username = 'postgres';
    $password_db = 'root';
    try{

        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password_db);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        // Prepare SQL statement for admin login
        $stmtAdmin = $pdo->prepare("SELECT * FROM admin_credentials WHERE admin_username = :username");
        $stmtAdmin->bindParam(':username', $adminUsername);
        $stmtAdmin->execute();
        $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

        // If admin found, set session and redirect to admin.php
        if ($admin && $adminPassword === $admin['admin_password']) {
           // $_SESSION['admin_id'] = $admin['id'];
           usleep(3000000);
            header('Location: UserData.php');
            exit();
        }

        // If no candidate or admin found, set error message
        $_SESSION['error_message'] = "Invalid username or password.";
        header('Location: ' . $_SERVER['PHP_SELF']); // Redirect to the same page to display error message
        exit();
        
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Connection failed: " . $e->getMessage();
    }
}
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Registration Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .error-message {
            color: red;
        }
    </style>
</head>
<body style="background-color: #1B1A55;">

<div class="container mt-5">
    <?php
          // Display error message if set
          if (isset($_SESSION['error_message'])) {
             
            usleep(3000000);
              echo '<div class="alert alert-danger text-center mt-3" role="alert">' . $_SESSION['error_message'] . '</div>';
              unset($_SESSION['error_message']); // Clear error message

                 // JavaScript code for delayed refresh after 2 seconds
echo '<script>';
echo 'setTimeout(function() { window.location.reload(); }, 3000);'; // Refresh after 2 seconds
echo '</script>';
          }
          ?>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card ">
        <div class="card-body ">
          <div class="row">
            
           
             <div class="col-md-5 text-white " style="background-color:#201658 ;">
             <h1 class="text-center fs-4 mb-4 mt-5">Admin Login</h1>
          <!-- Login Form -->
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-3 p-5" method="POST">
            <div class="mb-3">
              <label for="adminusername" class="form-label">Admin Username</label>
              <input type="text" class="form-control" id="adminusername" name="adminusername" required>
            </div>
            <div class="mb-3">
              <label for="adminpassword" class="form-label">Admin Password</label>
              <input type="password" class="form-control" id="adminpassword" name="adminpassword" required>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary mt-4 w-75">Sign in</button>
            </div>
          </form>
             </div>

            <div class="col-md-7">
              <img src="https://static.vecteezy.com/system/resources/previews/003/689/228/original/online-registration-or-sign-up-login-for-account-on-smartphone-app-user-interface-with-secure-password-mobile-application-for-ui-web-banner-access-cartoon-people-illustration-vector.jpg" style="width: 100%; height: 90%;" class="mt-4"/>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



</body>
</html>
