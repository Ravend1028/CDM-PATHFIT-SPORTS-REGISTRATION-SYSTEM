<?php include 'incs/header.php'; ?>

  <!-- Home Section -->
  <section class="home_section d-flex justify-content-center position-relative" style="height: 570px;">
    <video src="videos/CDM_1NTRO.mp4" class="object-fit-cover border rounded w-100" autoplay loop></video>
      
    <div class="d-flex flex-column justify-content-center align-items-center container w-100 h-100 position-absolute z-2 text-center text-sm-start">
        <h1 class="text-white mb-3 w-100">
          <span class="text-warning">
            Sports Development System:
          </span> 
          for Colegio de Muntinlupa
        </h1>

        <h5 class="text-white mb-3">
          Welcome to PathFit Portal! Join our upcoming events and explore sports and fitness opportunities. With seamless registration for activities like basketball and volleyball, we cater to all levels of enthusiasts. Whether you're a seasoned player or just starting out, our user-friendly process ensures you can easily secure your spot. Let's shape a brighter, fitter future together!
        </h5>

        <div class="d-flex"> 
          <?php if(isset($_SESSION['username'])): ?>
              <a href="/CDM-PATHFIT-SPORTS-REGISTRATION-SYSTEM/events.php" class="btn btn-dark btn-lg mt-2">
                <i class="bi bi-chevron-right"></i>
                Register Now
              </a>
          <?php elseif(isset($_SESSION['emp_username'])): ?>
              <a href="/CDM-PATHFIT-SPORTS-REGISTRATION-SYSTEM/admin_dashboard.php" class="btn btn-dark btn-lg mt-2">
                <i class="bi bi-chevron-right"></i>
                  Create Activity
              </a>
          <?php else: ?>
              <a href="/CDM-PATHFIT-SPORTS-REGISTRATION-SYSTEM/login.php" class="btn btn-dark btn-lg mt-2">
                  <i class="bi bi-chevron-right"></i>
                  Register Now
              </a>
            <?php endif; ?>
        </div>
    </div>   
  
    <div class="shadow-overlay position-absolute w-100 h-100" style="background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(5px);"></div>
  </section>

<?php include 'incs/footer.php'; ?>
  
