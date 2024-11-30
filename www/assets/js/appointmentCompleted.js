document.addEventListener('DOMContentLoaded', function() {
    let activateButtons = document.querySelectorAll('.btn-attended');

    activateButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            let id = this.getAttribute('data-id');

            fetch('/app/models/appointmentCompleted.php', {  
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded', 
                },
                body: 'id=' + encodeURIComponent(id) 
            })
            .then(response => response.text())
            .then(data => {
                document.querySelector('#messaje').innerText = data;

            })
            .catch(error => {
                document.querySelector('#messaje').innerText = error;

            });
        });
    });
});
