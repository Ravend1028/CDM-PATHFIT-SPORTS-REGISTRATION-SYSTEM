<?php include 'config/database.php'; ?>

<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PATHFIT</title>
  <!-- BOOTSTRAP CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="styles/general.css">
</head>
<body>

  <!-- HEADER NAVBAR STARTS HERE -->
  <nav class="navbar navbar-expand-lg bg-warning navbar-light z-2 p-2 border border-black border-top-0 border-start-0 border-end-0">
    <div class="container">
      <a href="/CDM-PATHFIT-SPORTS-REGISTRATION-SYSTEM/home.php" class="navbar-brand"><img class="mx-2" src="images/CDM_LOGO.png" alt="cdm_logo" style="height: 50px;">Colegio De Muntinlupa</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navmenu">
        <span class="navbar-toggler-icon">
        </span>
      </button>

      <div class="collapse navbar-collapse" id="navmenu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a href="/CDM-PATHFIT-SPORTS-REGISTRATION-SYSTEM/home.php" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="/CDM-PATHFIT-SPORTS-REGISTRATION-SYSTEM/announcements.php" class="nav-link">Announcements</a>
          </li>
          <li class="nav-item">
            <a href="/CDM-PATHFIT-SPORTS-REGISTRATION-SYSTEM/contacts.php" class="nav-link">Contacts</a>
          </li>

          <?php 
            if(isset($_SESSION['username'])) {
              $user = $_SESSION['username'];
              echo " 
                <li class='nav-item'>
                  <a href='/CDM-PATHFIT-SPORTS-REGISTRATION-SYSTEM/events.php' class='nav-link'>Events</a>
                </li>
                <li class='nav-item'>
                  <a href='student_dashboard.php' class='nav-link'>$user</a>
                </li>
                <li class='nav-item'>
                  <a href='/CDM-PATHFIT-SPORTS-REGISTRATION-SYSTEM/logout.php' class='nav-link'>Logout</a>
                </li>
                " ;
            } else if(isset($_SESSION['emp_username'])) {
              $user = $_SESSION['emp_username'];
              echo "
                <li class='nav-item'>
                  <a href='/CDM-PATHFIT-SPORTS-REGISTRATION-SYSTEM/events.php' class='nav-link'>Events</a>
                </li>
                <li class='nav-item'>
                  <a href='admin_dashboard.php' class='nav-link'>$user</a>
                </li>
                <li class='nav-item'>
                  <a href='/CDM-PATHFIT-SPORTS-REGISTRATION-SYSTEM/logout.php' class='nav-link'>Logout</a>
                </li>
                " ; 
            } else {
              echo " 
                <li class='nav-item'>
                  <a href='/CDM-PATHFIT-SPORTS-REGISTRATION-SYSTEM/login.php' class='nav-link'>Student Portal</a>
                </li>
                <li class='nav-item'>
                  <a href='/CDM-PATHFIT-SPORTS-REGISTRATION-SYSTEM/emp_login.php' class='nav-link'>Employee Portal</a>
                </li>
                ";
            }
          ?>

        </ul>
      </div>
    </div>
  </nav>