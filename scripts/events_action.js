document.addEventListener("DOMContentLoaded", function() {
  const removeBtnContainer = document.getElementById('remove-btn-container');
  
  removeBtnContainer.addEventListener('click', function(event) {
      if (event.target.classList.contains('remove-to-events')) {
          const eventId = event.target.closest('.event-section').getAttribute('data-prod-id');
          const sectionElement = event.target.closest('.event-section');
          removeToEvent(eventId, sectionElement);
      }
  });

  function removeToEvent(eventId, sectionElement) {
    const xhr = new XMLHttpRequest();

    xhr.open("POST", "events_action.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            alert(xhr.responseText); 
            if (sectionElement) {
              sectionElement.remove();
              window.location.reload();
            }
        } else {
            console.error('Request failed with status:', xhr.status);
        }
    };

    xhr.onerror = function() {
        console.error('Request failed');
    };

    xhr.send("event-id=" + encodeURIComponent(eventId));
  }
});