const detaliiDiv = document.getElementById('detalii');
const dataSpan = document.getElementById('dataProdus');
const detaliiButton = document.getElementById('btnDetalii');

const luni = [
    "Ianuarie", "Februarie", "Martie", "Aprilie", "Mai", "Iunie",
    "Iulie", "August", "Septembrie", "Octombrie", "Noiembrie", "Decembrie"
];

document.addEventListener('DOMContentLoaded', () => {
    
    detaliiDiv.classList.add('ascuns');
    const dataCurenta = new Date();
    const zi = dataCurenta.getDate();
    const lunaText = luni[dataCurenta.getMonth()];
    const an = dataCurenta.getFullYear();
    dataSpan.textContent = `${zi} ${lunaText} ${an}`;

});

detaliiButton.addEventListener('click', () => {
   
    detaliiDiv.classList.toggle('ascuns');
    
    if (detaliiDiv.classList.contains('ascuns')) {
        detaliiButton.textContent = 'Afiseaza detalii';
        
        detaliiButton.style.backgroundColor = '#28a745'; 
    } else {
        detaliiButton.textContent = 'Ascunde detalii';
        detaliiButton.style.backgroundColor = '#dc3545';
    }
});