<?php include 'incs/header.php'; ?>

<?php 
  $username = $password = $email = $fullname = $hashedPassword = $empID = '';
  $usernameErr = $passwordErr = $emailErr = $fullnameErr = 
  $empIDErr = $IncorrectID = $serverErr = '';

  if(isset($_POST['submit'])) {

    if(empty($_POST['username'])) {
      $usernameErr = 'Username is required';
    } else {
      $username = filter_input(
        INPUT_POST,
        'username',
        FILTER_SANITIZE_FULL_SPECIAL_CHARS
      );
    }

    if(empty($_POST['empID'])) {
      $empIDErr = 'Employee ID is required';
    } else {
      $empID = filter_input(
        INPUT_POST,
        'empID',
        FILTER_SANITIZE_FULL_SPECIAL_CHARS
      );
    }

    if(empty($_POST['password'])) {
      $passwordErr = 'Password is required';
    } else {
      $password = $_POST["password"];
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);   
    }

    if(empty($_POST['email'])) {
      $emailErr = 'Email is required';
    } else {
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    }

    if(empty($_POST['fullname'])) {
      $fullnameErr = 'Fullname is required';
    } else {
      $fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if (empty($usernameErr) && empty($passwordErr) && empty($emailErr) && empty($fullnameErr) && empty($empIDErr)) {
      
      $sql = "SELECT emp_code FROM emp_accounts";
      $result = mysqli_query($conn, $sql);

      if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $employeeID = $row['emp_code'];

        if($empID == $employeeID) {
          $sql = "INSERT INTO emp_accounts (username, password, fullname, email) VALUES ('$username', '$hashedPassword', '$fullname', '$email')";
          if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Account Created Successfully'); window.location='emp_login.php';</script>";
          } else {
            echo 'Error: ' . mysqli_error($conn);
          }
        } else {
          $IncorrectID = 'Incorrect Employee Code. Please try again.';
        }

      } else {
        $serverErr = 'Database not ready. Please try again later.';
      }
      
    }

  }
?>

  <section class="p-5">
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body text-center">
              <div class="mb-4">
                <h2>Sign Up</h2>
              </div>
              <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="mb-3 d-flex flex-column">
                  <label for="username" class="form-label align-self-start ms-5 ps-1 ps-sm-4">Username</label>
                  <input type="text" class="form-control <?php echo !$usernameErr ?: 'is-invalid'; ?> w-75 mx-auto rounded-pill" name="username" placeholder="Enter your username">
                </div>
                <div class="mb-0 d-flex flex-column">
                  <label for="empID" class="form-label align-self-start ms-5 ps-1 ps-sm-4">Employee Code</label>
                  <input type="text" class="form-control <?php echo !$empIDErr ?: 'is-invalid'; ?> w-75 mx-auto rounded-pill" name="empID" placeholder="Enter employee code">
                  <span class="text-danger m-2"><?php echo $IncorrectID ?></span>
                </div>
                <div class="mb-3 d-flex flex-column">
                  <label for="password" class="form-label align-self-start ms-5 ps-1 ps-sm-4">Password</label>
                  <input type="password" class="form-control <?php echo !$passwordErr ?: 'is-invalid'; ?> w-75 mx-auto rounded-pill" name="password" placeholder="Enter your password">
                </div>
                <div class="mb-3 d-flex flex-column">
                  <label for="fullname" class="form-label align-self-start ms-5 ps-1 ps-sm-4">Fullname</label>
                  <input type="text" class="form-control <?php echo !$fullnameErr ?: 'is-invalid'; ?> w-75 mx-auto rounded-pill" name="fullname" placeholder="Enter your fullname">
                </div>
                <div class="mb-4 d-flex flex-column">
                  <label for="email" class="form-label align-self-start ms-5 ps-1 ps-sm-4">Email</label>
                  <input type="email" class="form-control <?php echo !$emailErr ?: 'is-invalid'; ?> w-75 mx-auto rounded-pill" name="email" placeholder="Enter your email">
                </div>
                <div class="mb-3">
                  <input type="submit" name="submit" value="Sign Up" class="btn btn-dark btn-md rounded-pill w-75">
                </div>
              </form>
              <hr>
              <div class="mb-0">
                <a href="emp_login.php">Login</a>
                <span class="d-block text-danger m-2"><?php echo $serverErr?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php include 'incs/general_footer.php'; ?>