<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Include DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
</head>

<body class="bg-success">
  <div class="container">
    <h2 class="mt-4 text-center text-white fs-4 p-2 fw-bold bg-dark " style="font-family: 'Arial', sans-serif">ADMIN PANEL</h2>
    <table class="table table-dark table-bordered table-striped" id="employeetable">
      <thead class="mt-5">
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Age</th>
          <th>DOB</th>
        </tr>
      </thead>
      <tbody>
        <?php
          // Database connection
          $host = 'localhost';
          $dbname = 'gkblabs';
          $username = 'postgres';
          $password_db = 'root';

          $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password_db);

          // Fetch data from candidates table
          $sql = "SELECT name, email, age, dob FROM candidates";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll();

          if ($result) {
            // Output data of each row
            foreach($result as $row) {
              echo "<tr><td>" . $row["name"]. "</td><td>" . $row["email"]. "</td><td>" . $row["age"]. "</td><td>" . $row["dob"]. "</td></tr>";
            }
          } else {
            echo "0 results";
          }
        ?>
      </tbody>
    </table>
  </div>
  
  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Include jQuery library -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <!-- Include DataTables JS -->
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
  
  <script>
    // Initialize DataTable
    $(document).ready( function () {
      $('#employeetable').DataTable();
    });
  </script>
</body>
</html>
