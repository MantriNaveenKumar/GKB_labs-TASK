<?php
session_start();

if(isset($_SESSION['success_message'])) {
    usleep(3000000);
      echo '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                '.$_SESSION['success_message'].'
              </div>';
              unset($_SESSION['success_message']); // Clear success message
       // JavaScript code for delayed refresh after 2 seconds
  echo '<script>';
  echo 'setTimeout(function() { window.location.href="homepage.php" ; }, 4000);'; // Refresh after 2 seconds
  echo '</script>';       
      
  } elseif(isset($_SESSION['error_message'])) {
    usleep(3000000);
      echo '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                '.$_SESSION['error_message'].'
              </div>';
              unset($_SESSION['error_message']); // Clear error message
      // JavaScript code for delayed refresh after 2 seconds
  echo '<script>';
  echo 'setTimeout(function() { window.location.reload(); }, 3000);'; // Refresh after 2 seconds
  echo '</script>';        
     
  }


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $dob = $_POST['dob'];

    // Connect to PostgreSQL database
    $host = 'localhost';
    $dbname = 'gkblabs';
    $username = 'postgres';
    $password_db = 'root';

    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password_db);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if email already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM candidates WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // Email already registered, set error message
            $_SESSION['error_message'] = "Email already registered. Please use a different email address.";
        } else {
            // Email not registered, proceed with registration
            // Prepare SQL statement to insert data into the candidates table
            $sql = "INSERT INTO candidates (name, email, age, dob) VALUES (:name, :email, :age, :dob)";
            $stmt = $pdo->prepare($sql);

            // Bind parameters and execute the statement
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':age', $age);
            $stmt->bindParam(':dob', $dob);
           
            $stmt->execute();

            // Set success message
            $_SESSION['success_message'] = "Registration successful!";
        }

        // Redirect to the same page to prevent form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch (PDOException $e) {
        // Handle database errors
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
        // Redirect to the same page to prevent form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
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

<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-9">
      <div class="card ">
        <div class="card-body ">
          <div class="row">
            <div class="col-md-5 p-3 text-white" style="background-color: #FFC300  ">
              <h1 class="text-center fs-3 mb-4">Candidate Registration </h1>
              <form class="mt-5" id="registrationForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="mb-3">
                  <label for="name" class="form-label text-dark">Name</label>
                  <input type="text" class="form-control" id="name" name="name" required>
                  <div id="nameError" class="error-message"></div>
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label text-dark">Email</label>
                  <input type="email" class="form-control" id="email" name="email" required>
                  <div id="emailError" class="error-message"></div>
                </div>

                
                <div class="row">

                <div class="col-md-6 mb-3">
    <label for="age" class="form-label text-dark">Age</label>
    <input type="number" class="form-control" id="age" name="age" required>
    <div id="ageError" class="error-message"></div>
</div>

<div class="col-md-6 mb-3">
    <label for="dob" class="form-label text-dark">Date of Birth</label>
    <input type="date" class="form-control" id="dob" name="dob" required>
    <div id="dobError" class="error-message"></div>
</div>

                </div>
 



                <div class="form-check mb-3 mt-2">
                  <input type="checkbox" class="form-check-input" id="agree" name="agree">
                  <label class="form-check-label text-dark" for="agree">I agree to the terms of service</label>
                  <div id="agreeError" class="error-message"></div>
                </div>

                <div class="row text-center mt-4">
                     <div class="col ">
                     <button type="submit" class="btn btn-primary mt-3 w-75" id="RegisterButton">Register</button>
                     </div>
                </div>

              </form>

              <div class="row text-center">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label class="text-secondary mt-4">Are you Admin ? Click here </label>
        <div>
            <button id="adminButton" type="submit" class="btn btn-success btn-block mt-3 w-50">Admin Login</button>
        </div>
    </form>
</div>



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
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Function to navigate to candidateregister.php when the button is clicked
    document.getElementById("adminButton").addEventListener("click", function(event) {
     // usleep(3000000); 
     event.preventDefault(); 
     
        setTimeout(function() {
          window.location.href="Admin.php" ;
        }, 1000); // 2000 milliseconds = 2 seconds
    });
</script>


<script>
    $(document).ready(function () {
        $("#RegisterButton").click(function () {
            $(".error-message").text(""); // Clear previous error messages
            
            // Retrieve input values
            var name = $("#name").val();
            var email = $("#email").val();
            var age = $("#age").val();
            //var dob = $("#dob").val();
           


            var agree = $("#agree").prop("checked");

            // Validation
            var valid = true;

            if (!/^[a-zA-Z\s]+$/.test(name)) {
                $("#nameError").text("Name should contain only alphabets and spaces");
                valid = false;
            }

            if (!/\S+@\S+\.\S+/.test(email)) {
                $("#emailError").text("Invalid email format");
                valid = false;
            }
            
            
if (age < 0) {
    $("#ageError").text("Age cannot be negative");
    valid = false;
}
     
           


            if (!agree) {
                $("#agreeError").text("Please agree to the terms of service");
                valid = false;
            }

            return valid;
        });
    });
</script>
</body>
</html>