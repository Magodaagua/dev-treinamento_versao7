
    document.addEventListener('DOMContentLoaded', function () {
        var userLink = document.getElementById('userLink');
        var seta = document.getElementById('seta');
        var opUser = document.querySelector('.op-user');

        var logoutButton = document.getElementById('logout');

        userLink.addEventListener('click', function () {
            if (opUser.style.display === 'block') {
                opUser.style.display = 'none';
            } else {
                opUser.style.display = 'block';
            }
        });
        seta.addEventListener('click', function () {
            if (opUser.style.display === 'block') {
                opUser.style.display = 'none';
            } else {
                opUser.style.display = 'block';
            }
        });
    });