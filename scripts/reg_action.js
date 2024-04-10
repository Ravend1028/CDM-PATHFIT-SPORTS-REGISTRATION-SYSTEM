document.addEventListener("DOMContentLoaded", function() {
  const eventsContainer = document.getElementById('events-container');

  eventsContainer.addEventListener('click', function(event) {
    if (event.target.classList.contains('check-registration')) {
      event.preventDefault(); // Prevent default anchor behavior

      const registrationId = event.target.closest('.card').getAttribute('data-event-id');
      checkRegistration(registrationId);
    }
  });

  function checkRegistration(registrationId) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "display_entries.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
      if (xhr.status >= 200 && xhr.status < 300) {
          alert(xhr.responseText); 
          //window.location.replace("manage_user.php");
          //window.location.href = "manage_user.php";
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