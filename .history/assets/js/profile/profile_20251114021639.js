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

        this.initEvents();
    }

    initEvents() {
        // открытие формы для новой записи
        this.addBtn?.addEventListener('click', () => this.openForm('add'));
        // закрытие формы
        this.closeBtn?.addEventListener('click', () => this.toggleForm());

        // слушаем кастомное событие редактирования с CarCard
        document.querySelector('#main')?.addEventListener('edit', e => {
            this.openForm('edit', e.detail);
        });
    }

    toggleForm() {
        if (this.formModal) this.formModal.classList.toggle('modal-card-act');
    }

    resetForm() {
        Object.values(this.fields).forEach(input => {
            if (input) input.value = '';
        });
        if (this.msgBox) this.msgBox.classList.add('none');
    }

    fillForm(data) {
        if (this.fields.name) this.fields.name.value = data.name || '';
        if (this.fields.model) this.fields.model.value = data.model || '';
        if (this.fields.year) this.fields.year.value = data.year || '';
        if (this.fields.id) this.fields.id.value = data.id || '';
    }

    openForm(mode, data = {}) {
        this.resetForm();
        document.querySelector('.drop-area').innerteHTML = ' 2';
        if (mode === 'edit') {
            if (this.modalTitle) this.modalTitle.textContent = 'Edit Car';
            this.fillForm(data);
        } else {
            if (this.modalTitle) this.modalTitle.textContent = 'New Car';
        }

        this.toggleForm();
    }
}

// Инициализация
document.addEventListener('DOMContentLoaded', () => {
    new FormManager();
});
