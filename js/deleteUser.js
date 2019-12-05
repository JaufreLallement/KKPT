// Constants
const userListBox = document.getElementById("userlist-wrapper"); // User list container

// Functions

// Listeners
// Listener for delete user icons
userListBox.addEventListener("click", e => {
    // If the clicked element is a delete user icon : delete corresponding user
    if (e.target.classList.contains('delete-user')) {
        const icon = e.target; // Current target
        const userId = parseInt(icon.id.split('-')[0], 10); // Retreiving user id

        post('php/deleteUser.php', `deleteUser=${userId}`, response => {
            const responseJSON = JSON.parse(response); // Response from server
            const { status, msg, data } = responseJSON; // Get the type of data and data from response

            // Check if return data is valid
            if (status === "success") userListBox.innerHTML = data; // Update the userlist
            else alert(msg); // Get the php error
        });
    }
});