document.addEventListener("DOMContentLoaded", function() {
  const removeAnnouncementContainer = document.getElementById('announcement-container');
  
  removeAnnouncementContainer.addEventListener('click', function(event) {
      if (event.target.classList.contains('remove-to-announcements')) {
          const announcementId = event.target.closest('.card').getAttribute('data-prod-id');
          const cardElement = event.target.closest('.card');
          removeToEvent(announcementId, cardElement);
      }
  });

  function removeToEvent(announcementId, cardElement) {
    const xhr = new XMLHttpRequest();

    xhr.open("POST", "req_handler.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            alert(xhr.responseText); 
            if (cardElement) {
              cardElement.remove();
              window.location.reload();
            }
        } else {
            console.error('Request failed with status:', xhr.status);
        }
    };

    xhr.onerror = function() {
        console.error('Request failed');
    };

    xhr.send("announcement-id=" + encodeURIComponent(announcementId));
  }
});