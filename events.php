<?php include 'incs/header.php'; ?>

<?php
  $sql = 'SELECT * FROM events';
  $result = mysqli_query($conn, $sql);
  $events = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

  <div class="container d-flex flex-column justify-content-center align-items-center p-4">
    <h2>Events</h2>
    
    <?php if (empty($events)): ?>
      <p class="lead mt-3">There is no event</p>
    <?php endif; ?>
  </div>

  <div id="event-btn-container">
    <?php foreach ($events as $event): ?>
      <section class="event-section p-3 border border-black border-top-0 border-start-0 border-end-0"
        <?php if(isset($_SESSION['username'])) {
         echo 'data-user-id="' . $_SESSION['username'] . '"'; 
        }?>>
          <div class="container">
            <div class="row align-items-center justify-content-between">
              <div class="col-md">
                <?php
                // Check if product image is availables
                if (!empty($event['image'])) {
                  // Convert BLOB data to base64 format
                  $imgData = base64_encode($event['image']);
                  // Format the image source
                  $imgSrc = 'data:image/jpeg;base64,'.$imgData; // Change 'jpeg' based on your image type
                } else {
                  // If no image is available, use a placeholder
                  $imgSrc = 'images/CDM_LOGO.png';
                }
                ?>
                <img src="<?php echo $imgSrc; ?>" class="card-img-top" alt="" style="height: 250px;">
              </div>
              <div class="col-md p-5">
                <div class="text-dark text-uppercase mt-2 mb-3">
                  <?php echo $event['title']; ?>
                </div>

                <div class="text-dark mt-2 mb-3">
                  <?php echo $event['body']; ?>
                </div>
                
                <?php 
                  if(isset($_SESSION['username'])) {
                    echo "
                    <div class='d-flex'>
                      <button class='register-to-events btn btn-dark btn-md my-2' type='button' data-bs-toggle='modal' data-bs-target='#registrationModal'>
                        Register Now
                        <i class='bi bi-chevron-right'></i>
                      </button>
                    </div>
                    ";
                  } else if(isset($_SESSION['emp_username'])) {
                    echo "
                    <div class='d-flex'>
                      <button class='remove-to-events btn btn-dark btn-md my-2' type='button'>
                        Remove Event
                        <i class='bi bi-chevron-right'></i>
                      </button>
                    </div>
                    ";
                  }
                ?>
                
              </div>
            </div>
          </div>
      </section>      
    <?php endforeach; ?>
  </div>

  <div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="registrationModalLabel">Registration Form</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- INSERTING TO DB PROCESS - not done -->
          <form method="POST" action="reg_handler.php" data-prod-id="<?php echo $event['id']; ?>" >
            <div class="mb-3">
              <label for="fullName" class="form-label">Full Name</label>
              <input type="text" name="fullname" class="form-control" id="fullName" placeholder="Enter your full name">
            </div>
            <div class="mb-3">
              <label for="studentNumber" class="form-label">Student Number</label>
              <input type="text" name="studNumber" class="form-control" id="studNum" placeholder="Enter your student number">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email">
            </div>
            <div class="mb-3">
              <label for="medcert" class="form-label">Medical Certificate</label>
              <input type="file" name="medcert" class="form-control" id="medCert" placeholder="Upload your medcert">
            </div>
            <div class="mb-3">
              <label for="medcert" class="form-label">Certificate of Grades</label>
              <input type="file" name="cog" class="form-control" id="certGrade" placeholder="Upload your COG">
            </div>
              <input type="hidden" name="event_id" id="prodIdInput">
              <input type="hidden" name="username" id="userName">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-dark">Submit</button>
        </div>
      </div>
    </div>
  </div>


<?php include 'incs/general_footer.php'; ?>