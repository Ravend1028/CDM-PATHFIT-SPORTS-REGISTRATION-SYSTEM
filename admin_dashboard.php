<?php include 'incs/admin_header.php'; ?>

  <!-- ADMIN GREETING -->
  <section class="p-3 mt-2">
    <div class="container">
      <h1>
        Hi, 
        <?php
          $user = $_SESSION['emp_username'];
          echo "$user";
        ?>
      </h1>
    </div>
  </section>

  <!-- CARDS SECTION -->
  <section class="p-3">
      <div class="container">
        <div class="row text-center g-4">
          <div class="col-md">
            <div class="card bg-dark text-light">
              <div class="card-body text-center">
                <div class="h1 mb-3">
                  <i class="bi bi-laptop"></i>
                </div>
                <h3 class="card-title mb-3">Create Announcement</h3>
                <p class="card-text">
                  Elevate your admin experience with seamless functionality: 'Create an Announcement' simplifies communication, ensuring timely updates and engagement.
                </p>
                <a href="/CDM-PATHFIT-SPORTS-REGISTRATION-SYSTEM/create_announcements.php" class="btn btn-primary">Create Now <i class="bi bi-chevron-right"></i></a>
              </div>
            </div>
          </div>
          <div class="col-md">
            <div class="card bg-secondary text-light">
              <div class="card-body text-center">
                <div class="h1 mb-3">
                  <i class="bi bi-person-square"></i>
                </div>
                <h3 class="card-title mb-3">Create Event</h3>
                <p class="card-text">
                 Enhance your admin experience with streamlined navigation: 'Create an Event' allows for easy event planning.
                </p>
                <a href="/CDM-PATHFIT-SPORTS-REGISTRATION-SYSTEM/create_events.php" class="btn btn-dark">Create Now <i class="bi bi-chevron-right"></i></a>
              </div>
            </div>
          </div>
          <div class="col-md">
            <div class="card bg-dark text-light">
              <div class="card-body text-center">
                <div class="h1 mb-3">
                  <i class="bi bi-people"></i>
                </div>
                <h3 class="card-title mb-3">Check Registration</h3>
                <p class="card-text">
                  Optimize your administrative tasks with streamlined functionality: 'Check Registration' simplifies attendee management, providing quick access to crucial registration details.
                </p>
                <a href="/CDM-PATHFIT-SPORTS-REGISTRATION-SYSTEM/registration_list.php" class="btn btn-primary">Check Now <i class="bi bi-chevron-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

<?php include 'incs/footer.php' ?>