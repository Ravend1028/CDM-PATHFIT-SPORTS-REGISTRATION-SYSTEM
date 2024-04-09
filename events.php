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

  <div id="remove-btn-container">
    <?php foreach ($events as $event): ?>
      <section class="event-section p-3 border border-black border-top-0 border-start-0 border-end-0" data-prod-id="<?php echo $event['id']; ?>">
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
                      <button class='btn btn-dark btn-md my-2' type='button'>
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

<?php include 'incs/footer.php'; ?>