document.addEventListener("DOMContentLoaded", function() {
  const eventsContainer = document.getElementById('events-container');

  eventsContainer.addEventListener('click', function(event) {
      if (event.target.classList.contains('check-registration')) {
          event.preventDefault(); // Prevent default anchor behavior

          const registrationId = event.target.closest('.card').getAttribute('data-event-id');
          checkRegistration(registrationId, event.target);
      }
  });

  function checkRegistration(registrationId, anchorElement) {
      const xhr = new XMLHttpRequest();

      xhr.open("POST", "req_handler.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

      xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300 && xhr.responseText === 'ok') {
            // Redirect to manage_user.php if response is 'ok'
            window.location.href = '/CDM-PATHFIT-SPORTS-REGISTRATION-SYSTEM/manage_user.php';
        } else {
            const response = JSON.parse(xhr.responseText);
            if (response.status === 'ok') {
                alert(response.message);
                console.log('SQL Query:', response.query); // Display the SQL query in the console
            } else {
                alert("Request Failed: " + response.message);
            }
        }
      };

      xhr.onerror = function() {
          console.error('Request Failed');
      };

      xhr.send("reg-id=" + encodeURIComponent(registrationId));
  }
});

