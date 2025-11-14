function sendRequestPromise(url, method, data) {
    return new Promise((resolve, reject) => {
        const isFormData = data instanceof FormData;

        $.ajax({
            url,
            type: method,
            data,
            dataType: 'json',
            processData: !isFormData,
            contentType: !isFormData ? 'application/x-www-form-urlencoded; charset=UTF-8' : false,
            cache: false,
            success: function (response) {
                console.log("AJAX response:", response);

                if (response.success) {
                    resolve(response);
                } else {
                    reject(new Error(response.message || 'Unknown error'));
                }
            },
            error: function (xhr) {
                console.error("AJAX failed:", xhr);
                reject(new Error(xhr.responseText || 'Request failed'));
            }
        });
    });
}

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
            const response = await sendRequestPromise('../AuthController.php', 'POST', data);
            document.location.href = '../CarController.php';
        } catch (err) {
            console.error('Login error:', err);
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
            const response = await sendRequestPromise('../AuthController.php', 'POST', formData);
            document.location.href = '../AuthController.php';
        } catch (err) {
            console.error('Register error:', err);
            $('.msg').removeClass('none').text(err.message || 'Registration failed');
        }
    });
}

login();
register();
