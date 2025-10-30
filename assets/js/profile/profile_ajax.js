$(document).ready(function () {

    let currentStatus = 'all';
    let photo = null;

    function loadProducts(status = 'all') {
        $.ajax({
            url: 'carsList.php',
            type: 'POST',
            data: { status },
            success: function (data) {
                $('#main').html(data);
            },
            error: function (xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
    }

    loadProducts(currentStatus);

 
    $('#photo').on('change', function (e) {
        photo = e.target.files[0] || null;
        console.log('Selected photo:', photo);
    });

    $('.save-btn').on('click', function (e) {
        e.preventDefault();

        const name = $('#name').val().trim();
        const model = $('#model').val().trim();
        const year = $('#year').val().trim();
        const id = $('#FormID').val();

        const formData = new FormData();

        if (id > 0) {
            formData.append('status', 'update');
        }

        formData.append('name', name);
        formData.append('model', model);
        formData.append('year', year);
        formData.append('id', id);
 
        if (photo) {
            formData.append('photo', photo);
        } else {
 
            formData.append('photo', '');
        }

        $.ajax({
            url: '../../controllers/CarController.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                if (data.status) {
                    $('.modal-card').removeClass('modal-card-act');
                    loadProducts(currentStatus);
                    // 🔥 обнуляем переменную после сохранения
                    photo = null;
                    $('#photo').val('');
                } else {
                    $('.msg').removeClass('none').text(data.message || 'Error');
                }
            },
            error: function (xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
    });

    $(document).on('click', '.action-delete', function (e) {
        e.preventDefault();

        const id = $(this).closest('.product-box').find('.car-id').val();

        $.ajax({
            url: '../../controllers/CarController.php',
            type: 'POST',
            dataType: 'json',
            data: { id, status: 'delete' },
            success: function (data) {
                if (data.status) {
                    loadProducts(currentStatus);
                } else {
                    alert(data.message || 'Error deleting car');
                }
            },
            error: function (xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
    });

    $('#myCarBtn').on('click', function (e) {
        e.preventDefault();

        if (currentStatus === 'all') {
            currentStatus = 'myCar';
            $(this).addClass('active').text('All Cars');
        } else {
            currentStatus = 'all';
            $(this).removeClass('active').text('My Cars');
        }

        loadProducts(currentStatus);
    });
});
