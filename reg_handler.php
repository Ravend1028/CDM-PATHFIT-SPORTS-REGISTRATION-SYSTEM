<?php
  $conn = new mysqli('localhost', 'raven', '123456', 'pathfit');

  // Check connection
  if($conn->connect_error) {
		die('Connection failed: ' . $conn->connect_error);
	}

  //INSERTING TO DB PROCESS - not done 
  $fullName = $studentNumber = $email = $medicalCert = $certOfGrade = '';
  $fullNameErr = $studentNumberErr = $emailErr = $medicalCertErr = $certOfGradeErr = '';

  if(isset($_POST['submit'])) {
		
    if(empty($_POST['fullname'])) {
      $fullNameErr = 'Full name is required';
    } else {
      $fullName = filter_input(
        INPUT_POST,
        'fullname',
        FILTER_SANITIZE_FULL_SPECIAL_CHARS
      );
    }

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

    if(empty($_FILES['image']['name'])) {
      $imageErr = 'Image is required';
    } else {
        // Check if there was an error during file upload
        if($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Check if the uploaded file is an image
            $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
            $detectedType = exif_imagetype($_FILES['image']['tmp_name']);
            if(!in_array($detectedType, $allowedTypes)) {
                $medicalCertErr = 'Error: Only PNG, JPEG, and GIF images are allowed';
            } else {
                // Read the contents of the image file
                $medicalCert = file_get_contents($_FILES['image']['tmp_name']);
                // Check if the file size is not zero
                if($_FILES['image']['size'] == 0) {
                    $medicalCertErr = 'Error: Empty file uploaded';
                }
            }
        } else {
            $medicalCertErr = 'Error uploading image';
        }
    }

		if (empty($fullNameErr) && empty($studentNumberErr) && empty($emailErr) && empty($medicalCertErr) && empty($certOfGradeErr)) {
      $sql = "INSERT INTO reg_list (event_id, username, student_no, email, medcert, cog, fullname) VALUES (?, ?, ?, ?, ?)";
      // Prepare the statement
      $stmt = mysqli_prepare($conn, $sql);
      // Bind parameters to the statement
      mysqli_stmt_bind_param($stmt, "sssss", $fullName, $studentNumber, $email, $medicalCert, $certOfGrade);
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