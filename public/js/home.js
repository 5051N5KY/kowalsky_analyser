function openModal(img) {
    var modal = document.getElementById("modal");
    var modalImg = document.getElementById("modalImage");
    modal.style.display = "block";
    modalImg.src = img.src;
}

function closeModal() {
    var modal = document.getElementById("modal");
    modal.style.display = "none";
}

document.addEventListener('DOMContentLoaded', () => {
    // Dodanie funkcji usuwania plików
    window.deleteFile = function (filePath) {
        if (confirm('Czy na pewno chcesz usunąć ten obiekt?')) {
            console.log(filePath);
            fetch(deleteFileUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'path': filePath
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Obiekt usunięty!');
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert('Error deleting file: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the file');
                });
        }
    }
});