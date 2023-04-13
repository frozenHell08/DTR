let uploadButton = document.getElementById("upload-img");
let chosenImage = document.getElementById("chosen-image");
let filename = document.getElementById("file-name");

uploadButton.onchange = () => {
    let reader = new FileReader();
    reader.readAsDataURL(uploadButton.files[0]);
    reader.onload = () => {
        chosenImage.setAttribute("src", reader.result);
    }

    filename.textContent = uploadButton.files[0].name;
}

const bg = document.querySelector('.bg');
const btnPopup = document.querySelector('.btnEdit-popup');
const iconClose = document.querySelector('.icon-close');

btnPopup.addEventListener('click', ()=> {
    bg.classList.add('active-popup');
})

iconClose.addEventListener('click', ()=> {
    bg.classList.remove('active-popup');
})