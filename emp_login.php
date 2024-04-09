<?php include 'incs/header.php'; ?>

<?php 
  $username = $password = '';
  $usernameErr = $passwordErr = '';
  $incorrectPw = $unrecognizedUser = '';

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

    if(empty($_POST['password'])) {
      $passwordErr = 'Password is required';
    } else {
      $password = $_POST["password"];
    }

    if (empty($usernameErr) && empty($passwordErr)) {
      $sql = "SELECT password FROM emp_accounts WHERE username = '$username'";
      $result = mysqli_query($conn, $sql);

      if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $hashedPasswordFromDb = $row['password'];
    
            if (password_verify($password, $hashedPasswordFromDb)) {
              session_start();
              $_SESSION['emp_username'] = $username;
              header('Location: home.php');
            } else {
              $incorrectPw = 'Incorrect Username or Password';
            }

        } else {
          $unrecognizedUser = 'User does not exist';
        }
      } else {
        echo 'Error: ' . mysqli_error($conn);
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
                <h2>Employee Login</h2>
              </div>
              <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="mb-1 d-flex flex-column">
                  <label for="username" class="form-label align-self-start ms-5 ps-1 ps-sm-4">Username</label>
                  <input type="text" class="form-control <?php echo !$unrecognizedUser ?: 'is-invalid'; ?> w-75 mx-auto rounded-pill" name="username" placeholder="Enter your username">
                  <span class="text-danger m-2"><?php echo $incorrectPw ?></span>
                </div>
                <div class="mb-3 d-flex flex-column">
                  <label for="password" class="form-label align-self-start ms-5 ps-1 ps-sm-4">Password</label>
                  <input type="password" class="form-control <?php echo !$incorrectPw ?: 'is-invalid'; ?> w-75 mx-auto rounded-pill" name="password" placeholder="Enter your password">
                  <span class="text-danger m-2"><?php echo $incorrectPw ?></span>
                </div>
                <div class="mb-3">
                  <input type="submit" name="submit" value="Login" class="btn btn-dark btn-md rounded-pill w-75">
                </div>
              </form>
              <div class="mb-3">
                <a href="emp_forgotPass.php">Forgot Password</a>
              </div>
              <hr>
              <div class="mb-3">
                <a href="emp_signup.php">Create an Account</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php include 'incs/footer.php'; ?>