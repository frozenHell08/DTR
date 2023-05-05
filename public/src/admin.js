let elemid = e => document.getElementById(e);

let btn = document.querySelector('#btn'); // menu burger
let sidebar = document.querySelector('.sidebar'); //sidebar
let listItem = document.querySelectorAll('.list-item');

btn.onclick = function () {
    sidebar.classList.toggle('active');
}

function activeLink() {
    let icon;

    listItem.forEach(item => {
        item.classList.remove('active');
        icon = item.querySelector('i');
        if (icon.classList.contains('bx-cog') && item === this) {
            icon.classList.add('bx-spin');
        } else {
            icon.classList.remove('bx-spin');
        }
    });

    this.classList.add('active');
}

listItem.forEach(item =>
    item.onclick = activeLink);

// ---------------------------------------- | NAV LINK | ----------------------------------------

const links = document.querySelectorAll('a[data-target]');
const contents = document.querySelectorAll('[id$="content"]');

links.forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();

        const target = link.dataset.target;

        contents.forEach(content => {
            if (content.id === target) {
                content.classList.add('active');
            } else {
                content.classList.remove('active');
            }
        });
    });
});

// ---------------------------------------- | PROFILE | ----------------------------------------

const divprofile = document.querySelector('#profile');
const cardList = document.querySelectorAll('.card');
const closeprofile = document.getElementById("close-profile");

const emp_img = document.getElementById('userpic');
const emp_img_def = emp_img.getAttribute('src');
const emp_name = document.getElementById('user_name');
const emp_email = document.getElementById('user_email');

const emp_tit = elemid('tit');
const emp_tot = elemid('tot');
const emp_time = elemid('time');

const emp_table = elemid('timetable');
const ppbtn = elemid('printprevbtn');
let btndataid;

cardList.forEach(card => {
    card.addEventListener('click', async () => {
        const userId = card.dataset.id;

        fetch(`/admin/${userId}`)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            emp_img.src = `${window.location.origin}/${data.user.profile_picture.replace('public', 'storage')}`;
            emp_img.onerror = function() {
                emp_img.src = emp_img_def;
            }

            emp_name.textContent = `${data.user.firstName} ${data.user.lastName}`;
            emp_email.textContent = data.user.email;
            
            emp_time.textContent = data.time.total;
            emp_tit.textContent = data.time.in;
            emp_tot.textContent = data.time.out;

            ppbtn.setAttribute('data-id', userId);

            loadTable(emp_table, data.latest);
        
            btndataid = ppbtn.dataset.id;
            retrieveRecords('', '', mtable, btndataid);
        });

        divprofile.classList.add('active-popup');
        dateInput();
    });
});

closeprofile.addEventListener('click', () => {
    closeProfile(divprofile);
});

// ---------------------------------------- DATE INPUT ----------------------------------------

const from = document.querySelector('#from');
const to = document.querySelector('#to');
const alltime = document.querySelector('#alltime');
const mtable = elemid('timetable');

let datef, datet;

from.addEventListener('change', () => {
    datef = from.value;
    datet = to.value;
    retrieveRecords(datef, datet, mtable, btndataid);
});

to.addEventListener('change', () => {
    datef = from.value;
    datet = to.value;
    retrieveRecords(datef, datet, mtable, btndataid);
});

alltime.addEventListener('change', () => {
    from.value = '';
    to.value = '';
    retrieveRecords('', '', mtable, btndataid);
});

// ---------------------------------------- | PRINT PREVIEW | ----------------------------------------

const bgP = document.querySelector('.bg-print');
const closePrint = elemid("cancel-print");
const startPrint = elemid("btnPrint");
const tableprint = elemid('timetableprint');
const employname = elemid('employname');
const daterange = elemid('daterange');
const total = elemid('totalhours');

ppbtn.addEventListener('click', ()=> {
    bgP.classList.add('active-popup');

    const sourcebody = mtable.querySelector('tbody');
    const rows = sourcebody.querySelectorAll('tr');
    const printbody = elemid('tbprint');
    printbody.innerHTML = '';

    rows.forEach((row) => {
        const rowCopy = row.cloneNode(true);
        printbody.appendChild(rowCopy);
    });

    employname.querySelector('em').textContent = 'Employee Name : ' + emp_name.textContent;
});

closePrint.addEventListener('click', () => {
    bgP.classList.remove('active-popup');
});

startPrint.addEventListener('click', function() {
    print();
});

// ---------------------------------------- ESCAPE CLOSE ----------------------------------------

document.addEventListener('keydown', (event) => {
    if (event.key === "Escape") {
        if (bgP.classList.contains('active-popup')) {
            closeProfile(bgP);
            return
        }
        
        if (divprofile.classList.contains('active-popup')) {
            closeProfile(divprofile);
        }
    }
});

// ---------------------------------------- FUNCTIONS ----------------------------------------

function closeProfile(div) {
    div.classList.remove('active-popup');
}

function retrieveRecords(d1, d2, table, id) {
    let start = new Date(d1);
    let end = new Date(d2);
    let startmonth = start.toLocaleString('default', { month: 'long' });
    let endmonth = end.toLocaleString('default', { month: 'long' });

    fetch(`/dashboard/${id}/table?from=${d1}&to=${d2}`)
    .then(response => response.json())
    .then(data => {
        loadTable(table, data.data);
        console.log(data);

        start = new Date(data.data[0].date);
        end = new Date(data.data[data.data.length - 1].date);

        startmonth = start.toLocaleString('default', { month: 'long' });
        endmonth = end.toLocaleString('default', { month: 'long' });


        if (d1 === "") {
            daterange.innerHTML = `<em>Time Record from : ${startmonth} ${start.getDate()}, ${start.getFullYear()} 
            to ${endmonth} ${end.getDate()}, ${end.getFullYear()}</em>`; 
        } else if (d2 === "") {
            daterange.innerHTML = `<em>Time Record from : ${startmonth} ${start.getDate()}, ${start.getFullYear()} 
            to ${endmonth} ${end.getDate()}, ${end.getFullYear()}</em>`; 
        }

        total.textContent = `Total hours : ${data.totaltime}`;
    });
}

function loadTable(table, x) {
    table.getElementsByTagName('tbody')[0].innerHTML = '';
    x.forEach(row => {
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
}

function dateInput() {
    const rdbtns = document.getElementsByName('rctrl');
    const frominput = document.getElementById('from');
    const toinput = document.getElementById('to');

    rdbtns.forEach((button) => {
        if (button.checked && button.value) {
            frominput.disabled = true;
            toinput.disabled = true;
        } 
        
        if (button.checked && ! button.value){
            frominput.disabled = false;
            toinput.disabled = false;
        }

        button.addEventListener('click', () => {
            const disableInput = button.value;
    
            if (disableInput === 'true') {
                frominput.disabled = true;
                toinput.disabled = true;
            } else {
                frominput.disabled = false;
                toinput.disabled = false;
            }
        });
    });
}