<?php
	session_start();

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

	if (isset($_POST['reg-id'])) {
    $registrationID = $_POST['reg-id'];

    // Fetch event title along with registration names
    $sql = "SELECT accounts.fullname, events.title
            FROM reg_list
            JOIN events ON reg_list.event_id = events.id
            JOIN accounts ON reg_list.username = accounts.username
            WHERE reg_list.event_id = $registrationID";

    $result = $conn->query($sql);

    if ($result !== FALSE && $result->num_rows > 0) {
        $names = array();
        while ($row = $result->fetch_assoc()) {
            $names[] = $row['fullname'];
        }

        // Store the query result in the database
        $queryResult = serialize($names); // Convert the array to a serialized string
        $sqlInsert = "INSERT INTO query_results (event_id, result) VALUES ('$registrationID', '$queryResult')";
        
        // Execute the SQL query only if there are results
        if ($conn->query($sqlInsert) === TRUE) {
					echo json_encode(array("status" => "ok", "message" => "Registered successfully!", "query" => $sql)); // Send a JSON response to indicate success
				} else {
						echo json_encode(array("status" => "error", "message" => "Error: " . $sqlInsert . "<br>" . $conn->error));
				}
    } else {
			echo json_encode(array("status" => "error", "message" => "No registrations found for this Event"));
		}
	}

  // Close the connection
  $conn->close();
?>