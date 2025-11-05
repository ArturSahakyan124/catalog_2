const dragAndDrop = document.querySelector('.drop-area');

if (dragAndDrop) {
  dragAndDrop.addEventListener('dragenter', e => {
    e.preventDefault();
    alert('a')
  });

  dragAndDrop.addEventListener('dragleave', e => {
    e.preventDefault();
    alert('b')
  });

  dragAndDrop.addEventListener('dragover', e => e.preventDefault());
}
dragAndDrop.addEventListener('click', ()=>{


    console.log('wdw')
})