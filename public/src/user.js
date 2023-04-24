// ---------------------------------------- UPLOAD PREVIEW ----------------------------------------

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

// ---------------------------------------- EDIT ----------------------------------------

const bg = document.querySelector('.bg');
const btnPopup = document.querySelector('.btnEdit-popup');
const iconClose = document.querySelector('.icon-close');

btnPopup.addEventListener('click', ()=> {
    bg.classList.add('active-popup');
});

iconClose.addEventListener('click', ()=> {
    bg.classList.remove('active-popup');
});


// ---------------------------------------- PRINT ----------------------------------------

const bgP = document.querySelector('.bg-print');
const btnPrint = document.querySelector('.btnPrint-popup');
const closePrint = document.getElementById("cancel-print");

btnPrint.addEventListener('click', ()=> {
    bgP.classList.add('active-popup');
});

closePrint.addEventListener('click', () => {
    bgP.classList.remove('active-popup');
});

const startPrint = document.getElementById("btnPrint");

startPrint.addEventListener('click', function() {
    print();
});

function printContent() {
    printJS({
        printable: 'scroll-style',
        type: 'html',
        css: '/src/user.css',
        onComplete: function() {
            console.log('complete');
        }
    });
}

// ---------------------------------------- DATE INPUT ----------------------------------------

const from = document.querySelector('#from');
const to = document.querySelector('#to');
const datefrom = document.querySelector('label[for="from"]');
const dateto = document.querySelector('label[for="to"]');

dateinput(from, datefrom);
dateinput(to, dateto);

function dateinput(input, label) {
    label.addEventListener('click', (event) => {
        event.stopPropagation();

        if (input.classList.contains('active')) {
            checkInput(input);
            return;
        } else {
            input.classList.add('active');
        }
    });
}

document.addEventListener('click', (event) => {
    if (event.target.closest('#from') || event.target.closest('#to')) {
        return;
    }

    checkInput(from);
    checkInput(to);
});

function checkInput(inputElement) {
    if (inputElement.value === '') {
        inputElement.classList.remove('active');
    }
}

// ---------------------------------------- PRINT PREVIEW ----------------------------------------

const userID = document.querySelector('.print-area').dataset.userId;
const daterange = document.getElementById('daterange');
const table = document.getElementById('timetable');
const total = document.getElementById('totalhours');

from.addEventListener('change', () => {
    const datef = from.value;
    const datet = to.value;

    retrieveRecords(datef, datet, table);
});

to.addEventListener('change', () => {
    const datef = from.value;
    const datet = to.value;

    retrieveRecords(datef, datet, table);
});

function retrieveRecords(d1, d2, table) {
    const start = new Date(d1);
    const end = new Date(d2);
    const now = new Date();
    const startmonth = start.toLocaleString('default', { month: 'long' });
    const endmonth = end.toLocaleString('default', { month: 'long' });
    const nowmonth = now.toLocaleString('default', { month: 'long' });

    if (d2 === "") {
        daterange.innerHTML = `Time Record from ${startmonth} ${start.getDate()}, ${start.getFullYear()} 
        to ${nowmonth} ${now.getDate()}, ${now.getFullYear()}`;    
    } else {
        daterange.innerHTML = `Time Record from ${startmonth} ${start.getDate()}, ${start.getFullYear()} 
        to ${endmonth} ${end.getDate()}, ${end.getFullYear()}`;
    }

    fetch(`/dashboard/${userID}/table?from=${d1}&to=${d2}`)
    .then(response => response.json())
    .then(data => {
        table.getElementsByTagName('tbody')[0].innerHTML = '';

        data.data.forEach(row => {
            const timein = new Date(row.time_in);
            const ti_minutes = timein.getMinutes().toString().padStart(2, '0');
            const ti_seconds = timein.getSeconds().toString().padStart(2, '0');
            const formattedtimein = `${timein.getHours()}:${ti_minutes}.${ti_seconds}`;

            const timeout = new Date(row.time_out);
            const to_minutes = timeout.getMinutes().toString().padStart(2, '0');
            const to_seconds = timeout.getSeconds().toString().padStart(2, '0');
            const formattedtimeout = `${timeout.getHours()}:${to_minutes}.${to_seconds}`;

            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td>${row.date}</td>
                <td>${formattedtimein}</td>
                <td>${formattedtimeout}</td>
                <td>${row.duration}</td>
            `;
            table.getElementsByTagName('tbody')[0].appendChild(newRow);
        });

        total.textContent = `Total hours : ${data.totaltime}`;
    });
}