document.addEventListener("DOMContentLoaded", function() {
  const reglistContainer = document.getElementById('events-container');

  // Attach event listener to the parent container
  reglistContainer.addEventListener('click', function(event) {
    // Check if the clicked element is an approve or reject button
    if (event.target.classList.contains('approve-button')) {
      const regId = event.target.getAttribute('data-reg-id');
      updateRegistration(regId, 'approve');
    } else if (event.target.classList.contains('reject-button')) {
      const regId = event.target.getAttribute('data-reg-id');
      updateRegistration(regId, 'reject');
    }
  });

  function updateRegistration(regId, action) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "req_handler.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        if (xhr.status === 204) {
            // HTTP status code 204: No Content
            alert('Registration ' + action + 'd successfully!');
            // Remove the table row
            const rowToRemove = document.getElementById("table-row-" + regId);
            if (rowToRemove) {
                rowToRemove.remove();
            }
        } else if (xhr.status >= 200 && xhr.status < 300) {
            // Handle success response with content
            const response = xhr.responseText.trim();
            if (response === 'approve') {
                alert('Registration approved successfully!');
            } else if (response === 'reject') {
                alert('Registration rejected successfully!');
            } else {
                alert('Unknown response received.');
            }
        } else {
            // Handle other HTTP status codes
            console.error('Request failed with status:', xhr.status);
        }
    };

    xhr.onerror = function() {
        console.error('Request Failed. Network Error.');
    };

    // Send the registration ID and action in the request body
    xhr.send("reg-status=" + encodeURIComponent(regId) + "&action=" + encodeURIComponent(action));
  }
});
