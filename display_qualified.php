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
      // Fetch event title along with registration names and date_time
      $sql = "SELECT accounts.fullname, events.title, reg_list.date_time, reg_list.id
              FROM reg_list
              JOIN events ON reg_list.event_id = events.id
              JOIN accounts ON reg_list.username = accounts.username
              WHERE reg_list.event_id = $registrationID AND reg_list.reg_status = 1";

      // Execute the SQL query
      $result = mysqli_query($conn, $sql);

      // Fetch all registrations based on the query result
      $registers = mysqli_fetch_all($result, MYSQLI_ASSOC);

      // Close the connection
      $conn->close();

      // Format the date & time
      foreach ($registers as &$register) {
          $register['date_time'] = date('M d, Y \| h:i A', strtotime($register['date_time']));
      }
      unset($register); // Unset reference variable
  }
?>

  <div id="reglist-container" class="container">
    <?php if (!empty($registers)): ?>
        <!-- Display event title -->
        <div class="container">
            <div class="row">
                <div class="col p-3">
                    <h2 class="text-center">Qualified for <?php echo $registers[0]['title']; ?></h2>
                </div>
            </div>
        </div>

        <!-- Display registration table -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Registration Date & Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table rows will be dynamically added here -->
                            <?php foreach ($registers as $register): ?>
                                <tr id="table-row-<?php echo $register['id']; ?>">
                                    <td><?php echo $register['fullname']; ?></td>
                                    <td><?php echo $register['date_time']; ?></td>
                                    <td>
                                        <!-- Add cancel button with secondary color -->
                                        <button class="cancel-button btn btn-secondary" data-reg-id="<?php echo $register['id']; ?>">Cancel</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                     <!-- Add Print List button -->
                     <button class="print-list-button btn btn-dark">
                      Print List
                      <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- If $registers is empty or $_POST['reg-id'] is not set, display a message -->
        <p class='lead mt-3 text-center'>No one qualified yet.</p>
    <?php endif; ?>  
  </div>
