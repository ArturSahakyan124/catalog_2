// LOGIN
function login() {
    $('.login-btn').click(async function (e) {
        e.preventDefault();

        const login = $('input[name="login"]').val().trim();
        const password = $('input[name="password"]').val().trim();

        if (!login || !password) {
            $('.msg').removeClass('none').text('Please fill in all fields.');
            return;
        }

        const data = { action: 'login', login, password };

        try {
            await sendRequestPromise('conAuthController.php', 'POST', data);
            document.location.href = '../CarController.php';
        } catch (err) {
            $('.msg').removeClass('none').text(err.message || 'Login failed');
        }
    });
}

// REGISTRATION
function register() {
    $('#registerForm').on('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append('action', 'register');

        try {
            await sendRequestPromise('../AuthController.php', 'POST', formData);
            document.location.href = '../AuthController.php';
        } catch (err) {
            $('.msg').removeClass('none').text(err.message || 'Registration failed');
        }
    });
}

login();
register();