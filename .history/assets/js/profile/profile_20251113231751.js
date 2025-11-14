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
        //TODO: please  use f_ or js- to indicate classes used in js
        this.closeBtn = document.querySelector('.close');

        this.searchInput = document.querySelector('#search');

        this.initEvents();
    }

    initEvents() {
        this.addBtn?.addEventListener('click', () => this.openNewForm());
        this.closeBtn?.addEventListener('click', () => this.toggleForm());

        document.addEventListener('click', e => {
            const editBtn = e.target.closest('.edit-btn');
            if (editBtn) this.openEditForm(editBtn);
        });
    }

    toggleForm() {
        this.formModal.classList.toggle('modal-card-act');
    }

    resetForm() {
        this.modalTitle.textContent = "New Car";
        Object.values(this.fields).forEach(input => input.value = '');
        this.msgBox.classList.add('none');
    }

    openNewForm() {
        this.resetForm();
        this.toggleForm();
    }

    openEditForm(editBtn) {
        const card = editBtn.closest('.product-box');
        if (!card) return;

        const name = card.querySelector('.car-name')?.textContent.trim() || '';
        const model = card.querySelector('.model')?.textContent.trim() || '';
        const year = card.querySelector('.product-details')?.textContent.replace(/\D/g, '') || '';
        const id = card.querySelector('.car-id')?.value || '';

        this.modalTitle.textContent = "Edit Car";
        this.fields.name.value = name;
        this.fields.model.value = model;
        this.fields.year.value = year;
        this.fields.id.value = id;
        this.msgBox.classList.add('none');

        this.toggleForm();
    }
}

document.addEventListener('DOMContentLoaded', () => {

    new FormManager();

});

obisni kod