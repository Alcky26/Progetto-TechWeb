const months = [
    "Gennaio",
    "Febbraio",
    "Marzo",
    "Aprile",
    "Maggio",
    "Giugno",
    "Luglio",
    "Agosto",
    "Settembre",
    "Ottobre",
    "Novembre",
    "Dicembre"
];

const weekdays = ["Domenica", "Lunedi", "Martedi", "Mercoledi", "Giovedi", "Venerdi", "Sabato"];



// variabile principale
let date = new Date();
let resto;
// Funzione che restituisce la data di calendario corrente
function getCurrentDate(element, asString) {
    if (element) {
        if (asString) {
            return element.textContent = weekdays[date.getDay()] + ', ' + date.getDate() + " " + months[date.getMonth()] + " " + date.getFullYear();
        }
        return element.value = date.toISOString().substr(0, 10);
    }
    return date;
}


// Funzione principale che genera il calendario
function generateCalendar() {

    // Ottieni un calendario e se esiste già rimuovilo
    const calendar = document.getElementById('calendar');
    if (calendar) {
        calendar.remove();
    }

    // Crea la tabella che memorizzerà le date
    const table = document.createElement("table");
    table.id = "calendar";

    // Crea le intestazioni riferite ai giorni della settimana
    const trHeader = document.createElement('tr');
    trHeader.className = 'weekends';
    weekdays.map(week => {
        const th = document.createElement('th');
        const w = document.createTextNode(week.substring(0, 3));
        th.appendChild(w);
        trHeader.appendChild(th);
    });

    // Aggiungi intestazioni alla tabella
    table.appendChild(trHeader);

    //Ottieni il giorno della settimana dal primo giorno del mese
    const weekDay = new Date(
        date.getFullYear(),
        date.getMonth(),
        1
    ).getDay();

    //Ricevi l'ultimo giorno del mese
    const lastDay = new Date(
        date.getFullYear(),
        date.getMonth() + 1,
        0
    ).getDate();

    let tr = document.createElement("tr");
    let td = '';
    let empty = '';
    let btn = document.createElement('button');
    let week = 0;

    // Se il giorno della settimana del primo giorno del mese è maggiore di 0 (primo giorno della settimana);
    while (week < weekDay) {
        td = document.createElement("td");
        empty = document.createTextNode(' ');
        td.appendChild(empty);
        tr.appendChild(td);
        week++;
    }

    // Si svolgerà dal 1° all'ultimo giorno del mese
    for (let i = 1; i <= lastDay;) {
        // Finché il giorno della settimana è < 7, aggiungerà colonne alla riga della settimana.
        while (week < 7) {
            td = document.createElement('td');
            let text = document.createTextNode(i);
            btn = document.createElement('button');
            btn.className = "btn-day";
			      btn.type = "button";
			      btn.disabled = true;
            btn.addEventListener('click', function () { changeDate(this) });
            week++;

			if (i === new Date().getDate() && date.getMonth() === new Date().getMonth()){btn.id = "today";}


            // Controlla che si fermi esattamente l'ultimo giorno
            if (i <= lastDay) {
                i++;
                btn.appendChild(text);
                td.appendChild(btn);
            } else {
                text = document.createTextNode(' ');
                td.appendChild(text);
            }
            tr.appendChild(td);
        }
        // Aggiungi riga alla tabella
        table.appendChild(tr);

        // Crea una nuova linea da utilizzare
        tr = document.createElement("tr");

        // Azzera il contatore dei giorni della settimana
        week = 0;
    }
    // Aggiungi la tabella al div a cui dovrebbe appartenere
    const content = document.getElementById('table');
    content.appendChild(table);

    changeHeader(date);
    getCurrentDate(document.getElementById("currentDate"), true);

	activeBtn();
  changeActive();
	//disableDay();
}

// Metodo Cambia il mese e l'anno nella parte superiore del calendario
function changeHeader(dateHeader) {
    const month = document.getElementById("month-header");
    if (month.childNodes[0]) {
        month.removeChild(month.childNodes[0]);
    }
    const headerMonth = document.createElement("h1");
    const textMonth = document.createTextNode(months[dateHeader.getMonth()].substring(0, 3) + " " + dateHeader.getFullYear());
    headerMonth.appendChild(textMonth);
    month.appendChild(headerMonth);
}

// Funzione per cambiare il colore del pulsante del giorno che è attivo
function changeActive() {
    let btnList = document.querySelectorAll('button.active');
    btnList.forEach(btn => {
        btn.classList.remove('active');
    });
    btnList = document.getElementsByClassName('btn-day');
    for (let i = 0; i < btnList.length; i++) {
        const btn = btnList[i];
        if (btn.textContent === (date.getDate()).toString() && btn.disabled==false) {
            btn.classList.add('active');
        }
    }
}

// Funzione che prende la data corrente
function resetDate() {
    resto = 0;
    date = new Date();
    generateCalendar();
}

// Modificare la data in base al numero del pulsante cliccato
function changeDate(button) {
    let newDay = parseInt(button.textContent);
    date = new Date(date.getFullYear(), date.getMonth(), newDay);
    generateCalendar();
}

// mese e giorno funzioni avanti e indietro
function nextMonth() {
    date = new Date(date.getFullYear(), date.getMonth() + 1, 1);
    generateCalendar(date);
}

function prevMonth() {
    date = new Date(date.getFullYear(), date.getMonth() - 1, 1);
    generateCalendar(date);
}

function activeBtn() {
	let btnList = document.getElementsByClassName('btn-day');
	let todaybtn = document.getElementById('today');
    for (let i = 0; i < btnList.length; i++) {
      const btn = btnList[i];

      if (todaybtn){
      if (btn.textContent == todaybtn.textContent) {
			  var x = i + 1;
			  for (let j = 0; j < 13; j++){
			  	if(btnList[x]) {
			  	  var tmp = btnList[x];
			  	  tmp.disabled = false;
			  	  x++;
          } else {
            resto = 13 - j;
          }
	  		}
      }
    } else {
      if(resto > 0) {
        btn.disabled = false;
        resto--;
      }
    }
    }
}

document.onload = generateCalendar(date);
