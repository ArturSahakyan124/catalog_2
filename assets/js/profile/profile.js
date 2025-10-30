function openForm() {
  let form = document.querySelector('.modal-card');
  form.classList.toggle('modal-card-act');

  
    document.querySelector('#modalTitle').textContent = "New Card";
    document.querySelector('#name').value = "";
    document.querySelector('#model').value = "";
    document.querySelector('#year').value = "";
    document.querySelector('#FormID').value = "";
    document.getElementById('photo').value = '';

}

 

let addBtn = document.querySelector("#addBtn");
addBtn.addEventListener('click', openForm);


let xBtn = document.querySelector(".close-x");
xBtn.addEventListener('click', openForm);

document.addEventListener('click', e => {
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

});





const searchInput = document.querySelector('#search');

searchInput.addEventListener("input", function() {
  const query = searchInput.value.toLowerCase();

  const productTitles = document.querySelectorAll('.product-title');

  productTitles.forEach((titleElement) => {
    const productCard = titleElement.closest('.product-box');
    const text = titleElement.textContent.toLowerCase();

    if (text.includes(query)) {
      productCard.classList.remove('non-act');
    } else {
      productCard.classList.add('non-act');
    }
  });
});

