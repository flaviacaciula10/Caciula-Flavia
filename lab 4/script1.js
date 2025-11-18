// Definirea tabloului de luni
const LUNI = [
    "Ianuarie", "Februarie", "Martie", "Aprilie", "Mai", "Iunie",
    "Iulie", "August", "Septembrie", "Octombrie", "Noiembrie", "Decembrie"
];

function initListaActivitati() {
    // 1. Selectam elementele necesare
    const inputActivitate = document.getElementById("inputActivitate");
    const btnAdauga = document.getElementById("btnAdauga");
    const listaActivitati = document.getElementById("listaActivitati");

    // 2. Atasam un eveniment de 'click' butonului
    btnAdauga.addEventListener("click", function() {
        // Citim textul introdus in campul de input
        const textActivitate = inputActivitate.value.trim();

        // Verificam daca textul nu este gol
        if (textActivitate !== "") {
            // A. Preluam si formatam data curenta
            const d = new Date(); // Obiectul Date
            const zi = d.getDate(); // Ziua din luna
            const an = d.getFullYear(); // Anul
            const lunaText = LUNI[d.getMonth()]; // Luna in format text
            const dataFormatata = `${zi} ${lunaText} ${an}`;
            const continutLi = `${textActivitate} – adaugata la: ${dataFormatata}`;

            // B. Cream un nou element <li>
            const elementNou = document.createElement("li");
            
            // Setam continutul elementului <li>
            elementNou.textContent = continutLi;

            // C. Adaugam noul element in lista
            listaActivitati.appendChild(elementNou);

            // D. Golim campul de input dupa adaugare
            inputActivitate.value = "";
        }
    });
}

// Apelarea functiei doar dupa ce pagina este incarcata
if (document.getElementById("listaActivitati")) {
    initListaActivitati();
}