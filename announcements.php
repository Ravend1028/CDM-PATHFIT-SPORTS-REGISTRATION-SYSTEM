<?php include 'incs/header.php'; ?>

<?php
  $sql = 'SELECT * FROM announcements';
  $result = mysqli_query($conn, $sql);
  $announcements = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

  <div id="announcement-container" class="container d-flex flex-column justify-content-center align-items-center p-4">
    <h2>Announcements</h2>

    <?php if (empty($announcements)): ?>
      <p class="lead mt-3">There is no announcement</p>
    <?php endif; ?>

    <?php foreach ($announcements as $announcement): ?>
        <div class="card my-3" data-prod-id="<?php echo $announcement['id']; ?>">
          <?php
            // Check if product image is availables
            if (!empty($announcement['image'])) {
              // Convert BLOB data to base64 format
              $imgData = base64_encode($announcement['image']);
              // Format the image source
              $imgSrc = 'data:image/jpeg;base64,'.$imgData; // Change 'jpeg' based on your image type
            } else {
              // If no image is available, use a placeholder
              $imgSrc = 'images/CDM_LOGO.png';
            }
          ?>
          <img src="<?php echo $imgSrc; ?>" class="card-img-top" alt="" style="height: 300px;">
          <div class="card-body text-center">
            <div class="text-dark text-uppercase mt-2 mb-3">
              <?php echo $announcement['title']; ?>
            </div>

            <div class="text-dark mt-2">
              <?php echo $announcement['body']; ?>
            </div>

            <div class="text-secondary text-center mt-2">
              Published On: 
              <?php echo date_format(
              date_create($announcement['date_time']),
              'F j\, Y \- l \- g:ia  '
              ); ?>
            </div>
          </div>

          <?php 
            if(isset($_SESSION['emp_username'])) {
              echo "
              <div class='d-flex justify-content-center'>
                <button class='remove-to-announcements btn btn-dark btn-md my-2' type='button'>
                  Remove Announcement
                  <i class='bi bi-chevron-right'></i>
                </button>
              </div>
              ";
            } 
          ?>
        </div>
    <?php endforeach; ?>
  </div>

<?php include 'incs/general_footer.php'; ?>