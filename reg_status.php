<?php include 'incs/student_header.php'; ?>

<?php
  $username = $_SESSION['username'];

  $sql = "SELECT reg_list.username, events.title, reg_list.reg_status, reg_list.date_time
          FROM reg_list 
          JOIN events ON reg_list.event_id = events.id
          JOIN accounts ON reg_list.username = accounts.username
          WHERE reg_list.username = '$username'";

  // Execute the SQL query
  $result = mysqli_query($conn, $sql);

  // Fetch all registrations based on the query result
  $regList = mysqli_fetch_all($result, MYSQLI_ASSOC);

  // Close the connection
  $conn->close();

  // Format the date & time
  foreach ($regList as &$registration) {
    $registration['date_time'] = date('M d, Y \| h:i A', strtotime($registration['date_time']));
  }
  unset($registration); // Unset reference variable
?>

  <!-- Generate table -->
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <h2 class="text-center p-2"><?php echo $username; ?>'s Registration List</h2>
        <?php if (empty($regList)) : ?>
          <p class="text-center">No registrations yet.</p>
        <?php else : ?>
          <table class="table table-bordered text-center">
            <thead>
              <tr>
                <th>Event Title</th>
                <th>Registration Status</th>
                <th>Date & Time</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($regList as $registration) : ?>
                <tr>
                  <td><?php echo $registration['title']; ?></td>
                  <td class="<?php echo $registration['reg_status'] == 0 ? 'text-primary' : ($registration['reg_status'] == 1 ? 'text-success' : 'text-danger'); ?>">
                    <?php echo $registration['reg_status'] == 0 ? 'Pending' : ($registration['reg_status'] == 1 ? 'Accepted' : 'Not Accepted'); ?>
                  </td>
                  <td><?php echo $registration['date_time']; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>
    </div>
  </div>

<?php include 'incs/general_footer.php'; ?>