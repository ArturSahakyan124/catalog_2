$('.login-btn').click(function (e) {
    e.preventDefault();
    $('input').removeClass('error');

    const login = $('input[name="login"]').val();
    const password = $('input[name="password"]').val();
    const status = 'login'

    $.ajax({
        url: '../../controllers/AuthController.php',
        type: 'POST',
        dataType: 'json',
        data: { login, password,status},
        success: function (data) {
            if (data.status) {
                document.location.href = '../profile/userPage.php';
            } else {
 
                $('.msg').removeClass('none').text(data.message);
            }
        }
    });
});

// Registration
let avatar = null;
$('input[name="avatar"]').change(function (e) {
    avatar = e.target.files[0];
});

$('.register-btn').click(function (e) {
    e.preventDefault();
    $('input').removeClass('error');

    const login = $('input[name="login"]').val();
    const password = $('input[name="password"]').val();
    const email = $('input[name="email"]').val();


    const formData = new FormData();
    formData.append('login', login);
    formData.append('password', password);
 
 
    formData.append('email', email);
    formData.append('status', status);
    if (avatar) formData.append('avatar', avatar);

    $.ajax({
        url: '../../controllers/RegController.php',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        success: function (data) {
            if (data.status) {
                document.location.href = 'login.php';
            } else {
 
                $('.msg').removeClass('none').text(data.message);
            }
        }
    });
});
