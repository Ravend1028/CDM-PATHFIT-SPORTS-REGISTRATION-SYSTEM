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
      updateRegistration(regId, 'rejecte');
    } else if (event.target.classList.contains('reqImg')) {
      const imageUrl = event.target.getAttribute('src');
      showModal(imageUrl);
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
            } else if (response === 'rejecte') {
                alert('Registration rejected successfully!');
            } else {
                alert('Unknown response received.');
            }
        } 
    };

    xhr.onerror = function() {
        console.error('Request Failed. Network Error.');
    };

    // Send the registration ID and action in the request body
    xhr.send("reg-status=" + encodeURIComponent(regId) + "&action=" + encodeURIComponent(action));
  }

  function showModal(imageUrl) {
    const modalBody = `
      <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex justify-content-center align-items-center">
              <img src="${imageUrl}" alt="Image Preview" class="img-fluid w-50">
            </div>
          </div>
        </div>
      </div>
    `;
  
    // Append modal to body
    document.body.insertAdjacentHTML('beforeend', modalBody);
  
    // Show the modal
    const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
    imageModal.show();
  
    // Remove modal from DOM after it's hidden
    imageModal._element.addEventListener('hidden.bs.modal', function() {
      document.getElementById('imageModal').remove();
    });
  }  
});
