let currentStatus = 'all';
let photo = null;
let selectedFile = null;

$(document).ready(function () {
    initPhotoUpload();
    initSaveCard();
    initCarListToggle();
    loadProducts(currentStatus);
    initDragAndDrop();
    initDeleteCard(); 

    function initDragAndDrop() {
        const dropArea = $('.drop-area');
        const fileInput = $('.photo-input');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.on(eventName, function (e) {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        dropArea.on('dragover', () => dropArea.addClass('dragover'));
        dropArea.on('dragleave drop', () => dropArea.removeClass('dragover'));

        dropArea.on('drop', function (e) {
            const files = e.originalEvent.dataTransfer.files;
            if (files.length > 0) {
                selectedFile = files[0];
                photo = selectedFile;
                dropArea.find('p').text(`Selected file: ${selectedFile.name}`);
            }
        });

        fileInput.on('change', function (e) {
            selectedFile = e.target.files[0];
            photo = selectedFile;
            if (selectedFile) {
                dropArea.find('p').text(`Selected file: ${selectedFile.name}`);
            }
        });
    }

    function initPhotoUpload() {
        $('#photo').on('change', function (e) {
            photo = e.target.files[0] || null;
        });
    }

    function initSaveCard() {
        $('#carForm').on('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const id = Number($('#form-id').val());
            formData.append('status', id > 0 ? 'update' : 'create');

            if (photo) {
                formData.append('photo', photo);
            }

            try {
                await sendRequestPromise('../controllers/CarController.php', 'POST', formData);
                $('.modal-card').removeClass('modal-card-act');
                $('#carForm')[0].reset();
                $('.drag-and-drop p').text('Drop a photo here or select a file');
                photo = null;
                loadProducts(currentStatus);
            } catch (error) {
                $('.msg').removeClass('none').text(error.message || 'Error saving car');
            }
        });
    }

function initDeleteCard() { 
    
    $(document).on('click', '.delete-btn', async function (e) {
        e.preventDefault();
        
        const id = $(this).closest('.product-box').find('.car-id').val();
        if (!id) return;
 

        try {
            await sendRequestPromise('../controllers/CarController.php', 'POST', { id, status: 'delete' });
            loadProducts(currentStatus);
        } catch (err) {
            alert(err.message || 'Error deleting car');
        }
    });

    // кнопки внутри shadow DOM (CarCard)
    document.querySelector('#main')?.addEventListener('delete', async e => {
        const id = e.detail.id;
        if (!id) return;

 

        try {
            await sendRequestPromise('../controllers/CarController.php', 'POST', { id, status: 'delete' });
            loadProducts(currentStatus);
        } catch (err) {
            alert(err.message || 'Error deleting car');
        }
    });
}


    function initCarListToggle() {
        $('#myCarBtn').on('click', function (e) {
            e.preventDefault();

            if (currentStatus === 'all') {
                currentStatus = 'list';
                $(this).addClass('active').text('All Cars');
            } else {
                currentStatus = 'all';
                $(this).removeClass('active').text('My Cars');
            }

            loadProducts(currentStatus);
        });
    }

    async function loadProducts(status = 'all') {
        try {
            const data = await $.ajax({
                url: '../controllers/CarController.php',
                type: 'POST',
                data: { status },
            });
            $('#main').html(data);
        } catch (xhr) {
            $('.msg').removeClass('none').text('Failed to load cars');
        }
    }
});
