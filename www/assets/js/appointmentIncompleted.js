document.addEventListener('DOMContentLoaded', function() {
    let activateButtons = document.querySelectorAll('.btn-absent');

    activateButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            let id = this.getAttribute('data-id');

            fetch('/app/models/appointmentIncompleted.php', {  
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
