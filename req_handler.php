<?php
  $conn = new mysqli('localhost', 'raven', '123456', 'pathfit');

  // Check connection
  if($conn->connect_error) {
		die('Connection failed: ' . $conn->connect_error);
	}


  if(isset($_POST['event-id'])) {
		$eventId = $_POST['event-id'];
		
		$sql = "DELETE FROM events WHERE id = '$eventId'"; 
		if($conn->query($sql) === TRUE) {
				echo "Event removed successfully!";
		}else {
				echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

  if(isset($_POST['announcement-id'])) {
		$announcementId = $_POST['announcement-id'];
		
		$sql = "DELETE FROM announcements WHERE id = '$announcementId'"; 
		if($conn->query($sql) === TRUE) {
				echo "Announcement removed successfully!";
		}else {
				echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

	if(isset($_POST['reg-event-id']) && isset($_POST['user-id'])) {
		$registrationID = $_POST['reg-event-id'];
		$userID = $_POST['user-id'];
			
		$sql = "INSERT INTO reg_list (event_id, username) VALUES ('$registrationID', '$userID')"; 
		if($conn->query($sql) === TRUE) {
			echo "Registered successfully!";
		}else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

	if (isset($_POST['reg-status']) && isset($_POST['action'])) {
    $regId = $_POST['reg-status'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        // Handle approval logic
        $sql = "UPDATE reg_list SET reg_status = 1 WHERE id = $regId";
        if ($conn->query($sql) === TRUE) {
            echo "User has been approved successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($action === 'reject') {
        // Handle rejection logic
        $sql = "UPDATE reg_list SET reg_status = 2 WHERE id = $regId";
        if ($conn->query($sql) === TRUE) {
            echo "User has been rejected successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Invalid action specified.";
    }
	}
  // Close the connection
  $conn->close();
?>