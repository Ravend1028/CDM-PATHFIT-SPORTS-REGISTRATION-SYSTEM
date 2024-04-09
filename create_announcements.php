<?php include 'incs/admin_header.php'; ?>

<?php 
  $title = $content = $image = '';
  $titleErr = $contentErr = $imageErr = '';

  if(isset($_POST['submit'])) {

    if(empty($_POST['title'])) {
      $titleErr = 'Title is required';
    } else {
      $title = filter_input(
        INPUT_POST,
        'title',
        FILTER_SANITIZE_FULL_SPECIAL_CHARS
      );
    }

    if(empty($_POST['body'])) {
      $contentErr = 'Content is required';
    } else {
      $content = filter_input(
        INPUT_POST,
        'body',
        FILTER_SANITIZE_FULL_SPECIAL_CHARS
      );
    }

    if(empty($_FILES['image']['name'])) {
      $imageErr = 'Image is required';
    } else {
        // Check if there was an error during file upload
        if($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Check if the uploaded file is an image
            $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
            $detectedType = exif_imagetype($_FILES['image']['tmp_name']);
            if(!in_array($detectedType, $allowedTypes)) {
                $imageErr = 'Error: Only PNG, JPEG, and GIF images are allowed';
            } else {
                // Read the contents of the image file
                $image = file_get_contents($_FILES['image']['tmp_name']);
                // Check if the file size is not zero
                if($_FILES['image']['size'] == 0) {
                    $imageErr = 'Error: Empty file uploaded';
                }
            }
        } else {
            $imageErr = 'Error uploading image';
        }
    }
  
    if (empty($titleErr) && empty($contentErr) && empty($imageErr)) {
      $sql = "INSERT INTO announcements (title, body, image) VALUES (?, ?, ?)";
      // Prepare the statement
      $stmt = mysqli_prepare($conn, $sql);
      // Bind parameters to the statement
      mysqli_stmt_bind_param($stmt, "sss", $title, $content, $image);
      // Execute the statement
      if (mysqli_stmt_execute($stmt)) {
          echo "<script>alert('Announcement Published Successfully'); window.location='/CDM-PATHFIT-SPORTS-REGISTRATION-SYSTEM/admin_dashboard.php';</script>";
      } else {
          // Error handling
          echo 'Error: ' . mysqli_error($conn);
      }
      // Close the statement
      mysqli_stmt_close($stmt);  
    }

  }
?>

  <!-- ANNOUNCEMENT FORM -->
  <section class="p-5">
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body text-center">
              <div class="mb-4">
                <h2>Create Announcement</h2>
              </div>
              <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                <div class="mb-0 d-flex flex-column">
                  <label for="title" class="form-label align-self-start ms-5 ps-1 ps-sm-4">Announcement Title</label>
                  <input type="text" class="form-control <?php echo !$titleErr ?: 'is-invalid'; ?> w-75 mx-auto rounded-pill" name="title" placeholder="Enter Announcement Title">
                  <span class="text-danger m-2"><?php echo $titleErr ?></span>
                </div>
                <div class="mb-0 d-flex flex-column">
                  <label for="body" class="form-label align-self-start ms-5 ps-1 ps-sm-4">Announcement Details</label>
                  <textarea class="form-control <?php echo !$contentErr ?: 'is-invalid'; ?> w-75 mx-auto" name="body" placeholder="Enter Announcement Details" rows="4"></textarea>
                  <span class="text-danger m-2"><?php echo $contentErr ?></span>
                </div>
                <div class="mb-0 d-flex flex-column">
                  <label for="file" class="form-label align-self-start ms-5 ps-1 ps-sm-4">Announcement Image</label>
                  <input type="file" class="form-control <?php echo !$imageErr ?: 'is-invalid'; ?> w-75 mx-auto rounded-pill" name="image" placeholder="Upload Announcement Image">
                  <span class="text-danger m-2"><?php echo $imageErr ?></span>
                </div>
                <hr>
                <div class="mb-3">
                  <input type="submit" name="submit" value="Publish" class="btn btn-dark btn-md rounded-pill w-75">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php include 'incs/footer.php' ?>