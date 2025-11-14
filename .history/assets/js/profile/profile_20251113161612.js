function openForm() {
  const form = document.querySelector('.modal-card');
  form.classList.toggle('modal-card-act');

  document.querySelector('#modalTitle').textContent = "New Card";
  document.querySelector('#name').value = "";
  document.querySelector('#model').value = "";
  document.querySelector('#year').value = "";
  document.querySelector('#FormID').value = "";
  document.getElementById('photo').value = '';
}

class FormHandler {
  constructor() {
    this.addBtn = document.querySelector("#addBtn");
    this.closeBtn = document.querySelector(".close-x");
    this.searchInput = document.querySelector('#search');
    this.dropArea = document.getElementById('dropArea');
    this.fileInput = document.getElementById('photo');
    this.preview = document.getElementById('preview');
    this.previewImg = document.getElementById('previewImg');
    this.init();
  }

  init() {
    this.addBtn.addEventListener('click', openForm);
    this.closeBtn.addEventListener('click', openForm);
    document.addEventListener('click', e => this.handleEdit(e));
    this.searchInput.addEventListener("input", () => this.search());
    //this.initDragAndDrop();
  }

  initDragAndDrop() {
    this.dropArea.addEventListener('click', () => this.fileInput.click());
    this.dropArea.querySelector('.browse').addEventListener('click', e => {
      e.stopPropagation();
      this.fileInput.click();
    });

    this.dropArea.addEventListener('dragover', e => {
      e.preventDefault();
      this.dropArea.classList.add('dragover');
    });

    this.dropArea.addEventListener('dragleave', e => {
      e.preventDefault();
      this.dropArea.classList.remove('dragover');
    });

    this.dropArea.addEventListener('drop', e => {
      e.preventDefault();
      this.dropArea.classList.remove('dragover');
      const file = e.dataTransfer.files[0];
      this.showPreview(file);
    });

    this.fileInput.addEventListener('change', () => {
      const file = this.fileInput.files[0];
      this.showPreview(file);
    });
  }

  showPreview(file) {
    if (!file || !file.type.startsWith('image/')) return;
    const reader = new FileReader();
    reader.onload = e => {
      this.previewImg.src = e.target.result;
      this.preview.classList.remove('none');
    };
    reader.readAsDataURL(file);
  }

  handleEdit(e) {
    const btn = e.target.closest('.action-edit');
    if (!btn) return;
    const card = btn.closest('.product-box');
    if (!card) return;

    const name  = card.querySelector('.car-name').textContent.trim();
    const model = card.querySelector('.model').textContent.trim();
    const year  = card.querySelector('.product-details').textContent.replace(/\D/g, '');
    const id    = card.querySelector('.car-id').value;

    openForm();
    document.querySelector('#modalTitle').textContent = "Edit Product";
    document.querySelector('#name').value = name;
    document.querySelector('#model').value = model;
    document.querySelector('#year').value = year;
    document.querySelector('#FormID').value = id;
  }

  search() {
    const query = this.searchInput.value.toLowerCase();
    document.querySelectorAll('.product-title').forEach(title => {
      const card = title.closest('.product-box');
      title.textContent.toLowerCase().includes(query)
        ? card.classList.remove('non-act')
        : card.classList.add('non-act');
    });
  }
}

new FormHandler();
