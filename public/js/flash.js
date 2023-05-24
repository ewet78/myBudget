function removeFlashMessage() {
    var flashMessage = document.getElementById('flash-message');
    if (flashMessage) {
    flashMessage.remove();
    }
}

// Specify the duration in milliseconds (e.g., 5000 for 5 seconds)
var duration = 2500;

// Set a timer to remove the flash message after the specified duration
setTimeout(removeFlashMessage, duration);

