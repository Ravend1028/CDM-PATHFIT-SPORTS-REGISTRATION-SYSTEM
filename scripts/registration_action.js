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

    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          window.location.href = "manage_user.php";
        } else {
          console.error('Request Failed. Status:', xhr.status);
        }
      }
    };

    xhr.onerror = function() {
      console.error('Request Failed. Network Error.');
    };

    xhr.send("reg-id=" + encodeURIComponent(registrationId));
  }
});

