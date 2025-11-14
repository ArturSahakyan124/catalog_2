class CarCard extends HTMLElement {
    constructor() {
        super();
        this.attachShadow({ mode: 'open' });
    }

    connectedCallback() {
        const props = this.getProps();
        const template = document.getElementById('car-card-template');
        const clone = template.content.cloneNode(true);

        this.fillData(clone, props);

        if (props.editable) this.initButtons(clone, props);

        this.shadowRoot.appendChild(clone);
    }

    getProps() {
        return {
            photo: this.getAttribute('photo') || ' ',
            name: this.getAttribute('name') || 'Unknown',
            model: this.getAttribute('model') || '-',
            year: this.getAttribute('year') || '-',
            id: this.getAttribute('id') || '-',
            username: this.getAttribute('username') || '-',
            editable: this.getAttribute('editable') === 'true'
        };
    }

    fillData(clone, { photo, name, model, year, id, username }) {
        clone.querySelector('.product-img').src = photo;
        clone.querySelector('.car-name').textContent = name;
        clone.querySelector('.model').textContent = model;
        clone.querySelector('.product-details').textContent = `Year: ${year}`;
        clone.querySelector('.car-id').textContent = `ID: ${id}`;
        clone.querySelector('.car-user').textContent = `User: ${username}`;
    }

    initButtons(clone, { id, name, model, year, username }) {
        const btnContainer = clone.querySelector('.product-btns-container');
        btnContainer.style.display = 'flex';

        clone.querySelector('.edit-btn').addEventListener('click', () => {
            this.dispatchEvent(new CustomEvent('edit', {
                detail: { id, name, model, year, username },
                bubbles: true,
                composed: true
            }));
        });

        clone.querySelector('.delete-btn').addEventListener('click', () => {
            this.dispatchEvent(new CustomEvent('delete', {
                detail: { id },
                bubbles: true,
                composed: true
            }));
        });
    }
}

customElements.define('car-card', CarCard);
