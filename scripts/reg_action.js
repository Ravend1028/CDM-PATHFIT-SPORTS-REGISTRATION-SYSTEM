document.addEventListener("DOMContentLoaded", function() {
  const eventsContainer = document.getElementById('events-container');

  eventsContainer.addEventListener('click', function(event) {
    if (event.target.classList.contains('check-registration')) {
      event.preventDefault(); // Prevent default anchor behavior

      const registrationId = event.target.closest('.card').getAttribute('data-event-id');
      checkRegistration(registrationId);
    }
    
    if(event.target.classList.contains('check-qualified') || event.target.parentElement.classList.contains('check-qualified')) {
      event.preventDefault(); // Prevent default button behavior

      const registrationId = event.target.closest('.card').getAttribute('data-event-id');
      checkQualified(registrationId);
    }

    if(event.target.classList.contains('check-rejected') || event.target.parentElement.classList.contains('check-rejected')) {
      event.preventDefault(); // Prevent default button behavior

      const registrationId = event.target.closest('.card').getAttribute('data-event-id');
      checkRejected(registrationId);
    }

    // Add event listener for cancel button
    if(event.target.classList.contains('cancel-button')) {
      event.preventDefault(); // Prevent default button behavior

      const registrationId = event.target.getAttribute('data-reg-id');
      cancelRegistration(registrationId);
    }

    // Add event listener for print button
    if (event.target.classList.contains('print-list-button')) {
      event.preventDefault(); // Prevent default button behavior
      window.print(); // This will trigger the browser's print dialog
    }
  });

  function checkRegistration(registrationId) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "display_entries.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
      if (xhr.status >= 200 && xhr.status < 300) {
        document.getElementById("events-container").innerHTML = xhr.responseText;
      } else {
        console.error('Request failed with status:', xhr.status);
      }
    };

    xhr.onerror = function() {
      console.error('Request Failed. Network Error.');
    };

    // Send the registration ID in the request body
    xhr.send("reg-id=" + encodeURIComponent(registrationId));
  }

  function checkQualified(registrationId) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "display_qualified.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
      if (xhr.status >= 200 && xhr.status < 300) {
        document.getElementById("events-container").innerHTML = xhr.responseText;
      } else {
        console.error('Request failed with status:', xhr.status);
      }
    };

    xhr.onerror = function() {
      console.error('Request Failed. Network Error.');
    };

    // Send the registration ID in the request body
    xhr.send("reg-id=" + encodeURIComponent(registrationId));
  }

  // Function to cancel registration
  function cancelRegistration(registrationId) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "req_handler.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  
    xhr.onload = function() {
      if (xhr.status >= 200 && xhr.status < 300) {
        alert('Registration cancelled successfully'); // Alert the response from the server
        const rowToRemove = document.getElementById("table-row-" + registrationId); // Get the table row element
        if (rowToRemove) {
          rowToRemove.remove(); // Remove the table row
        }
      } else {
        console.error('Request failed with status:', xhr.status);
      }
    };
  
    xhr.onerror = function() {
      console.error('Request Failed. Network Error.');
    };
  
    // Send the registration ID in the request body
    xhr.send("cancel-id=" + encodeURIComponent(registrationId));
  }

  function checkRejected(registrationId) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "display_rejected.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
      if (xhr.status >= 200 && xhr.status < 300) {
        document.getElementById("events-container").innerHTML = xhr.responseText;
      } else {
        console.error('Request failed with status:', xhr.status);
      }
    };

    xhr.onerror = function() {
      console.error('Request Failed. Network Error.');
    };

    // Send the registration ID in the request body
    xhr.send("reg-id=" + encodeURIComponent(registrationId));
  }
});

