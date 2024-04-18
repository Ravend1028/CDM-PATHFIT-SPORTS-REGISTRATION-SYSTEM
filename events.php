<?php include 'incs/header.php'; ?>

<?php
  $sql = 'SELECT * FROM events';
  $result = mysqli_query($conn, $sql);
  $events = mysqli_fetch_all($result, MYSQLI_ASSOC);

  $studentNumber = $email = $medicalCert = $certOfGrade = $eventID = $userID = '';
  $studentNumberErr = $emailErr = $medicalCertErr = $certOfGradeErr = '';

  if(isset($_POST['submit'])) {
 
    $eventID = $_POST['eventId'];
    $userID = $_POST['userId'];
   
    if(empty($_POST['studNumber'])) {
      $studentNumberErr = 'Student number is required';
    } else {
      $studentNumber = filter_input(
        INPUT_POST,
        'studNumber',
        FILTER_SANITIZE_FULL_SPECIAL_CHARS
      );
    }

    if(empty($_POST['email'])) {
      $emailErr = 'Email is required';
    } else {
      $email = filter_input(
        INPUT_POST,
        'email',
        FILTER_SANITIZE_EMAIL
      );
    }

    if(empty($_FILES['medcert']['name'])) {
      $imageErr = 'Image is required';
    } else {
        // Check if there was an error during file upload
        if($_FILES['medcert']['error'] === UPLOAD_ERR_OK) {
            // Check if the uploaded file is an image
            $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
            $detectedType = exif_imagetype($_FILES['medcert']['tmp_name']);
            if(!in_array($detectedType, $allowedTypes)) {
                $medicalCertErr = 'Error: Only PNG, JPEG, and GIF images are allowed';
            } else {
                // Read the contents of the image file
                $medicalCert = file_get_contents($_FILES['medcert']['tmp_name']);
                // Check if the file size is not zero
                if($_FILES['medcert']['size'] == 0) {
                    $medicalCertErr = 'Error: Empty file uploaded';
                }
            }
        } else {
            $medicalCertErr = 'Error uploading image';
        }
    }

    if(empty($_FILES['cog']['name'])) {
      $certOfGradeErr = 'Image is required';
    } else {
        // Check if there was an error during file upload
        if($_FILES['cog']['error'] === UPLOAD_ERR_OK) {
            // Check if the uploaded file is an image
            $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
            $detectedType = exif_imagetype($_FILES['cog']['tmp_name']);
            if(!in_array($detectedType, $allowedTypes)) {
                $certOfGradeErr = 'Error: Only PNG, JPEG, and GIF images are allowed';
            } else {
                // Read the contents of the image file
                $certOfGrade = file_get_contents($_FILES['cog']['tmp_name']);
                // Check if the file size is not zero
                if($_FILES['cog']['size'] == 0) {
                    $certOfGradeErr = 'Error: Empty file uploaded';
                }
            }
        } else {
            $certOfGradeErr = 'Error uploading image';
        }
    }

		if (empty($studentNumberErr) && empty($emailErr) && empty($medicalCertErr) && empty($certOfGradeErr)) {
      $sql = "INSERT INTO reg_list (event_id, username, student_no, email, medcert, cog) VALUES (?, ?, ?, ?, ?, ?)";
      // Prepare the statement
      $stmt = mysqli_prepare($conn, $sql);
      // Bind parameters to the statement
      mysqli_stmt_bind_param($stmt, "ssssss", $eventID, $userID, $studentNumber, $email, $medicalCert, $certOfGrade);
      // Execute the statement
      if (mysqli_stmt_execute($stmt)) {
          echo "<script>alert('Registered Successfully!'); window.location='/CDM-PATHFIT-SPORTS-REGISTRATION-SYSTEM/events.php';</script>";
      } else {
          // Error handling
          echo 'Error: ' . mysqli_error($conn);
      }
      // Close the statement
      mysqli_stmt_close($stmt);  
    }
	}
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
      data-prod-id = "<?php echo $event['id']; ?>"
      <?php 
        if(isset($_SESSION['username'])) {
            echo '
            data-user-id="' . $_SESSION['username'] . '"';
        } 
      ?>>
          <div class="container">
            <div class="row align-items-center justify-content-between">
              <div class="col-md d-flex justify-content-center">
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
              <div class="col-md p-5 text-center d-flex flex-column justify-content-center align-items-center">
                <div class="text-dark text-uppercase mt-2 mb-3">
                  <?php echo $event['title']; ?>
                </div>

                <div class="text-dark mb-4">
                  <?php echo $event['body']; ?>
                </div>
                
                <?php 
                  if(isset($_SESSION['username'])) {
                    echo "
                    <div class='d-flex'>
                      <button class='register-to-event btn btn-dark btn-md my-2' type='button' data-bs-toggle='modal' data-bs-target='#registrationModal'>
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
        <div class="modal-body" >
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
            <input type="hidden" name="eventId" id="eventId">
            <input type="hidden" name="userId" id="userId">
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
            <input type="hidden" name="event_id" id="regEventId">
            <input type="hidden" name="username" id="regUsername">
            <div class="modal-footer pb-0">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" name="submit" class="btn btn-dark">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<?php include 'incs/general_footer.php'; ?>