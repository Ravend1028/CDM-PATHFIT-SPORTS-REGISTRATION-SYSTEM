<?php
$conn = new mysqli('localhost', 'raven', '123456', 'pathfit');

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Check if product ID is provided
if (isset($_POST['event-id'])) {
  // Get product ID from AJAX request
  $eventId = $_POST['event-id'];
  
  $sql = "DELETE FROM events WHERE id = '$eventId'"; 
  if ($conn->query($sql) === TRUE) {
      echo "Event removed successfully!";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

// Close the connection
$conn->close();
?>