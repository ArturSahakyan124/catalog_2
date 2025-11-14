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

        this.shadowRoot.innerHTML = `
            <link rel="stylesheet" href="../assets/css/main.css">
            <link rel="stylesheet" href="../assets/css/profile.css">
            <div class="product-box">
                <img class="product-img" src="${photo}" alt="Photo">
                <div class="product-info">
                    <div class="product-title">
                        <div class="car-name">${name}</div>
                        <div class="model">${model}</div>
                    </div>
                    <div class="product-details">Year: ${year}</div>
                    <div>ID: ${id}</div>
                    <div>User: ${username}</div>
                </div>
                ${editable ? `
                <div class="product-btns-container">
                    <button class="product-btns edit-btn primary-btn">Edit</button>
                    <button class="product-btns delete-btn secondary-btn">Delete</button>
                </div>` : ''}
            </div>
        `;

        // ✅ Добавляем слушатели событий
        if (editable) {
            const editBtn = this.shadowRoot.querySelector('.edit-btn');
            const deleteBtn = this.shadowRoot.querySelector('.delete-btn');

            editBtn?.addEventListener('click', () => {
                this.dispatchEvent(new CustomEvent('edit', {
                    detail: { id, name, model, year, username },
                    bubbles: true,
                    composed: true
                }));
            });

            deleteBtn?.addEventListener('click', () => {
                this.dispatchEvent(new CustomEvent('delete', {
                    detail: { id },
                    bubbles: true,
                    composed: true
                }));
            });
        }
    }
}

customElements.define('car-card', CarCard);
