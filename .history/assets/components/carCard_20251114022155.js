class CarCard extends HTMLElement {
    constructor() {
        super();
        this.attachShadow({ mode: 'open' });
    }

    connectedCallback() {
        const photo = this.getAttribute('photo') || '../assets/images/default.jpg';
        const name = this.getAttribute('name') || 'Unknown';
        const model = this.getAttribute('model') || '-';
        const year = this.getAttribute('year') || '-';
        const id = this.getAttribute('id') || '-';
        const username = this.getAttribute('username') || '-';
        const editable = this.getAttribute('editable') === 'true';

        const template = document.getElementById('car-card-template');
        const clone = template.content.cloneNode(true);

        clone.querySelector('.product-img').src = photo;
        clone.querySelector('.car-name').textContent = name;
        clone.querySelector('.model').textContent = model;
        clone.querySelector('.product-details').textContent = `Year: ${year}`;
        clone.querySelector('.car-id').textContent = `ID: ${id}`;
        clone.querySelector('.car-user').textContent = `User: ${username}`;

        if (editable) {
            const btnContainer = clone.querySelector('.product-btns-container');
            btnContainer.style.display = 'flex';

            const editBtn = clone.querySelector('.edit-btn');
            const deleteBtn = clone.querySelector('.delete-btn');

            editBtn.addEventListener('click', () => {
                this.dispatchEvent(new CustomEvent('edit', {
                    detail: { id, name, model, year, username },
                    bubbles: true,
                    composed: true
                }));
            });

            deleteBtn.addEventListener('click', () => {
                this.dispatchEvent(new CustomEvent('delete', {
                    detail: { id },
                    bubbles: true,
                    composed: true
                }));
            });
        }

        this.shadowRoot.appendChild(clone);
    }
}

customElements.define('car-card', CarCard);
