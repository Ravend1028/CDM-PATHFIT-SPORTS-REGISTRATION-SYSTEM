<?php include 'incs/student_header.php'; ?>

  <!-- STUDENT GREETING -->
  <section class="p-3 mt-2">
    <div class="container">
      <h1>
        Hi, 
        <?php
          $user = $_SESSION['username'];
          echo "$user";
        ?>
      </h1>
    </div>
  </section>

  <!-- CARDS SECTION -->
  <section class="p-3">
      <div class="container">
        <div class="row text-center g-4">
          <div class="col-md-4">
            <div class="card bg-dark text-light">
              <div class="card-body text-center">
                <div class="h1 mb-3">
                  <i class="bi bi-laptop"></i>
                </div>
                <h3 class="card-title mb-3">Registration Status</h3>
                <p class="card-text">
                   Elevate your experience on the student portal with streamlined functionality. Our 'Registration Results' feature facilitates easy navigation, providing quick access to registration outcomes and ensuring efficient engagement with your academic or client services.
                </p>
                <a href="/CDM-PATHFIT-SPORTS-REGISTRATION-SYSTEM/reg_status.php" class="btn btn-primary">View Now<i class="bi bi-chevron-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>

<?php include 'incs/footer.php' ?>

