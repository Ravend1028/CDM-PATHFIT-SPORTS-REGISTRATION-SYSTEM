document.addEventListener("DOMContentLoaded", function() {
	const eventBtnContainer = document.getElementById('event-btn-container');

	// Event listener for button clicks
	eventBtnContainer.addEventListener('click', function(event) {
			if (event.target.classList.contains('remove-to-events')) {
					const eventId = event.target.closest('.event-section').getAttribute('data-prod-id');
					const sectionElement = event.target.closest('.event-section');
					removeToEvent(eventId, sectionElement);
			}

			if (event.target.classList.contains('register-to-event')) {
					const eventId = event.target.closest('.event-section').getAttribute('data-prod-id');
					const userId = event.target.closest('.event-section').getAttribute('data-user-id');
					const sectionElement = event.target.closest('.event-section');
					registerToEvent(eventId, userId, sectionElement);
			}
	});

	// Function to remove event
	function removeToEvent(eventId, sectionElement) {
			const xhr = new XMLHttpRequest();
			xhr.open("POST", "req_handler.php", true);
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

	// Function to register to event
	function registerToEvent(eventId, userId, sectionElement) {
			const xhr = new XMLHttpRequest();

			xhr.open("POST", "req_handler.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

			xhr.onload = function() {
					if (xhr.status >= 200 && xhr.status < 300) {
							alert(xhr.responseText); 
							const registerButton = sectionElement.querySelector('.register-to-event');
							registerButton.disabled = true;
							registerButton.classList.add('disabled');
					} else {
							console.error('Request failed with status:', xhr.status);
					}
			};

			xhr.onerror = function() {
					console.error('Request failed');
			};

			xhr.send("reg-event-id=" + encodeURIComponent(eventId) + "&user-id=" + encodeURIComponent(userId));
	}
});

