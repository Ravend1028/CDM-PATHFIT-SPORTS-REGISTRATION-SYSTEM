<?php include 'incs/admin_header.php'; ?>

<?php
  $sql = 'SELECT * FROM events';
  // Execute the SQL query
  $result = mysqli_query($conn, $sql);
  // Fetch all products based on the query result
  $events = mysqli_fetch_all($result, MYSQLI_ASSOC);

  if (empty($events)) {
    echo "<p class='lead mt-3 text-center'>No Event Listed</p>";
  }
?>

  <div id="products-container" class="container">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-4">
      <?php
      // Function to display products
      function displayProducts($events) {
        foreach ($events as $event):
      ?>

      <div class="col">
        <div class="card my-3" style="height: 95%;" data-product-id="<?php echo $event['id']; ?>">
          <?php
            // Check if product image is availables
            if (!empty($event['image'])) {
              // Convert BLOB data to base64 format
              $imgData = base64_encode($event['image']);
              // Format the image source
              $imgSrc = 'data:image/jpeg;base64,'.$imgData; // Change 'jpeg' based on your image type
            } else {
              // If no image is available, use a placeholder
              $imgSrc = 'placeholder.jpg'; // Change to your placeholder image path
            }
          ?>
          <img src="<?php echo $imgSrc; ?>" class="card-img-top" style="height: 200px;" alt="">
          <div class="card-body text-center">
            <?php echo $event['title']; ?>
            <div class="text-dark mt-2"><?php echo $event['body']; ?></div>
            <button class="add-to-cart btn btn-dark mt-4">Check Registration</button>
          </div>
        </div>
      </div>

      <?php
        endforeach;
      }
      displayProducts($events);
      ?>
    </div>
  </div>

<?php include 'incs/footer.php' ?>