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
  // Close the connection
  $conn->close();
?>