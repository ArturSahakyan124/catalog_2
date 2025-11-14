class FormManager {
    constructor() {
        this.formModal = document.querySelector('.modal-card');
        this.modalTitle = document.querySelector('.modal-title');
        this.fields = {
            name: document.querySelector('#name'),
            model: document.querySelector('#model'),
            year: document.querySelector('#year'),
            id: document.querySelector('#form-id'),
            photo: document.querySelector('#photo')
        };
        this.msgBox = document.querySelector('.msg');
        this.addBtn = document.querySelector('#add-btn');
        this.closeBtn = document.querySelector('.close');

        this.photo = null;

        this.initEvents();
    }

    initEvents() {
        this.addBtn?.addEventListener('click', () => this.openForm('add'));
        this.closeBtn?.addEventListener('click', () => this.toggleForm());

        document.addEventListener('click', e => {
            const editBtn = e.target.closest('.edit-btn');
            if (editBtn) {
                const card = editBtn.closest('car-card, .product-box');
                if (!card) return;

                const data = {
                    name: card.querySelector('.car-name')?.textContent.trim() || '',
                    model: card.querySelector('.model')?.textContent.trim() || '',
                    year: card.querySelector('.product-details')?.textContent.replace(/\D/g, '') || '',
                    id: card.querySelector('.car-id')?.value || card.getAttribute('data-id') || ''
                };

                this.openForm('edit', data);
            }
        });

        this.fields.photo.addEventListener('change', e => {
            this.photo = e.target.files[0] || null;
        });
    }

    toggleForm() {
        this.formModal.classList.toggle('modal-card-act');
    }

    resetForm() {
        Object.values(this.fields).forEach(input => {
            if (input) input.value = '';
        });
        this.photo = null;
        this.msgBox.classList.add('none');
    }

    fillForm(data) {
        this.fields.name.value = data.name || '';
        this.fields.model.value = data.model || '';
        this.fields.year.value = data.year || '';
        this.fields.id.value = data.id || '';
    }

    openForm(mode, data = {}) {
        this.resetForm();
        if (mode === 'edit') {
            this.modalTitle.textContent = 'Edit Car';
            this.fillForm(data);
        } else {
            this.modalTitle.textContent = 'New Car';
        }
        this.toggleForm();
    }

    async saveCar() {
        const form = document.querySelector('#carForm');
        const formData = new FormData(form);
        const id = this.fields.id.value;

        formData.append('status', id ? 'update' : 'create');

        // добавляем фото только если выбрали новое
        if (this.photo) formData.append('photo', this.photo);

        try {
            await sendRequestPromise('../controllers/CarController.php', 'POST', formData);
            this.toggleForm();
            form.reset();
            loadProducts(currentStatus);
        } catch (err) {
            this.msgBox.classList.remove('none');
            this.msgBox.textContent = err.message || 'Error saving car';
        }
    }
}

// инициализация
document.addEventListener('DOMContentLoaded', () => {
    const manager = new FormManager();
    document.querySelector('#carForm').addEventListener('submit', e => {
        e.preventDefault();
        manager.saveCar();
    });
});
