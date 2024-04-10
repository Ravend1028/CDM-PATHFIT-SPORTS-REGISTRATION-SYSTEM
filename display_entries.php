<?php
  // Fetch and format registration details
  $conn = new mysqli('localhost', 'raven', '123456', 'pathfit');

  // Check connection
  if ($conn->connect_error) {
      die('Connection failed: ' . $conn->connect_error);
  }

  // Check if reg-id is set in POST request
  if (isset($_POST['reg-id'])) {
    $registrationID = $_POST['reg-id'];
    // Define SQL query with search condition
    // Fetch event title along with registration names
    $sql = "SELECT accounts.fullname, events.title
            FROM reg_list
            JOIN events ON reg_list.event_id = events.id
            JOIN accounts ON reg_list.username = accounts.username
            WHERE reg_list.event_id = $registrationID";

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);

    // Fetch all registrations based on the query result
    $registers = mysqli_fetch_all($result, MYSQLI_ASSOC);
  }

  // Close the connection
  $conn->close();
?>

<!-- Display event title and registration table if $registers is not empty -->
<?php if (!empty($registers)): ?>
    <!-- Display event title -->
    <div class="container">
        <div class="row">
            <div class="col p-3">
                <h2><?php echo $registers[0]['title']; ?></h2>
            </div>
        </div>
    </div>

    <!-- Display registration table -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registers as $register): ?>
                            <tr>
                                <td class="text-center"><?php echo $register['fullname']; ?></td>
                                <td class="text-center">
                                    <!-- Add approve/reject buttons here -->
                                    <button class="btn btn-success me-1">Approve</button>
                                    <button class="btn btn-danger ms-1">Reject</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php else: ?>
    <!-- If $registers is empty or $_POST['reg-id'] is not set, display a message -->
    <p class='lead mt-3 text-center'>No one registered yet.</p>
<?php endif; ?>


