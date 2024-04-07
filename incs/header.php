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
</head>
<body>

  <!-- HEADER NAVBAR STARTS HERE -->
  <nav class="navbar navbar-expand-md bg-light navbar- z-2 p-3 border border-black border-top-0 border-start-0 border-end-0">
    <div class="container">
      <a href="#" class="navbar-brand">PATHFIT</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navmenu">
        <span class="navbar-toggler-icon">
        </span>
      </button>

      <div class="collapse navbar-collapse" id="navmenu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a href="#" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Announcement</a>
          </li>

          <?php 
            if(isset($_SESSION['username'])) {
              $user = $_SESSION['username'];
              echo " 
              <li class='nav-item'>
                <a href='#' class='nav-link'>$user</a>
              </li>

              <li class='nav-item'>
                <a href='#' class='nav-link'>Logout</a>
              </li>
              " ;
            } else {
              echo " 
              <li class='nav-item'>
            <a href='#' class='nav-link'>Student Portal</a>
              </li>
              <li class='nav-item'>
                <a href='#' class='nav-link'>Employee Portal</a>
              </li>
              ";
            }
          ?>

          <li class="nav-item">
            <a href="#" class="nav-link">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>