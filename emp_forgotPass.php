<?php include 'incs/header.php'; ?>

<?php 
  $username = $password = $repassword = $hashedPassword = $empID = '';
  $usernameErr = $passwordErr = $repasswordErr =  
  $mismatchPw = $userNotExist =  $empIDErr =  $IncorrectID = '';

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

    if(empty($_POST['repassword'])) {
      $passwordErr = 'Password is required';
    } else {
      $repassword = password_hash('repassword', PASSWORD_DEFAULT); 
    }

    if (empty($usernameErr) && empty($passwordErr) && empty($repasswordErr)) {
      $sql = "SELECT * FROM emp_accounts WHERE username = '$username'";
      $result = mysqli_query($conn, $sql);

      if(mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          $employeeID = $row['emp_code'];

        if($empID == $employeeID) {

          if($_POST['password'] == $_POST['repassword']) {
            $sql = "UPDATE accounts SET password = '$hashedPassword' WHERE username = '$username'";
            
            if (mysqli_query($conn, $sql)) {
              echo "<script>alert('Password Changed Successfully'); window.location='emp_login.php';</script>";
            } else {
              echo 'Error: ' . mysqli_error($conn);
            }

          } else {
            $mismatchPw = 'The passwords do not match. Please try again.';
          }

        } else {
          $IncorrectID = 'Incorrect Employee Code. Please try again.';
        }

      } else {
        $userNotExist = 'The username does not exist. Please try again.';
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
                <h2>Forgot Password</h2>
              </div>
              <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="mb-0 d-flex flex-column">
                  <label for="username" class="form-label align-self-start ms-5 ps-1 ps-sm-4">Username</label>
                  <input type="text" class="form-control <?php echo !$usernameErr ?: 'is-invalid'; ?> w-75 mx-auto rounded-pill" name="username" placeholder="Enter your username">
                  <span class="text-danger m-2"><?php echo $userNotExist ?></span>
                </div>
                <div class="mb-0 d-flex flex-column">
                  <label for="empID" class="form-label align-self-start ms-5 ps-1 ps-sm-4">Employee Code</label>
                  <input type="text" class="form-control <?php echo !$empIDErr ?: 'is-invalid'; ?> w-75 mx-auto rounded-pill" name="empID" placeholder="Enter employee code">
                  <span class="text-danger m-2"><?php echo $IncorrectID ?></span>
                </div>
                <div class="mb-3 d-flex flex-column">
                  <label for="password" class="form-label align-self-start ms-5 ps-1 ps-sm-4">Password</label>
                  <input type="password" class="form-control <?php echo !$passwordErr ?:
                  'is-invalid'; ?> w-75 mx-auto rounded-pill" name="password" placeholder="Enter new password">
                </div>
                <div class="mb-4 d-flex flex-column">
                  <label for="repassword" class="form-label align-self-start ms-5 ps-1 ps-sm-4">Retype Password</label>
                  <input type="password" class="form-control <?php echo !$passwordErr ?: 'is-invalid'; ?> w-75 mx-auto rounded-pill" name="repassword" placeholder="Retype new password">
                  <span class="text-danger m-2"><?php echo $mismatchPw; ?></span>
                </div>
                <div class="mb-3">
                  <input type="submit" name="submit" value="Confirm" class="btn btn-dark btn-md rounded-pill w-75">
                </div>
              </form>
              <hr>
              <div class="mb-3">
                <a href="emp_login.php">Login</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php include 'incs/general_footer.php'; ?>