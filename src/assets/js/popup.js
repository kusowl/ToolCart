const modalEl = document.getElementById('info-popup');

const closeBtn = document.getElementById('close-modal');
closeBtn.addEventListener('click',() =>{
    closeButton();
});
function closeButton() {
    modalEl.style.display="none";
}
