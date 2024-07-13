function updateStatus(id, status) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4) {
            if (this.status == 200) {
                alert("Outpass request " + status + " successfully");
                // Optionally, you can reload the page or update the UI without reloading
            } else {
                console.error("Error updating outpass request: " + this.status + " - " + this.statusText);
            }
        }
    };
    xhttp.onerror = function() {
        console.error("Network error occurred while updating outpass request.");
    };
    xhttp.open("POST", "update_status.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + id + "&status=" + status);
}
