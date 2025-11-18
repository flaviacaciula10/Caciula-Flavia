document.addEventListener('DOMContentLoaded', () => {
    // 1. Incarca cosul din localStorage sau initializeaza-l ca array gol
    let cart = JSON.parse(localStorage.getItem('shoppingCart')) || [];

    // 2. Gaseste elementele principale din HTML
    // NOTA: Acestea vor exista doar in pagina cosului (pag cos de cumparaturi.html)
    const cartTableBody = document.querySelector('.tabel-cos tbody');
    const totalRow = document.querySelector('.rand-total');

    // Functie pentru salvarea cosului in localStorage
    const saveCart = () => {
        localStorage.setItem('shoppingCart', JSON.stringify(cart));
    };

    // Functie pentru actualizarea vizuala a cosului si a totalului
    const updateCartDisplay = () => {
        // Iesim daca nu suntem in pagina cosului de cumparaturi
        if (!cartTableBody || !totalRow) return; 

        // Goleste continutul curent al cosului
        cartTableBody.innerHTML = '';
        let grandTotal = 0;

        // Adauga fiecare produs in tabel
        cart.forEach((item, index) => {
            const row = document.createElement('tr');
            row.classList.add('articol-cos'); 

            // Calculeaza totalul pentru produsul curent
            const itemTotal = item.price * item.quantity;
            grandTotal += itemTotal;

            row.innerHTML = `
                <td data-label="Produs:">${item.name}</td>
                <td data-label="Preț Unitar:">${item.price.toFixed(2)} RON</td>
                <td data-label="Cantitate:">
                    <input type="number" 
                           class="camp-cantitate" 
                           value="${item.quantity}" 
                           min="1" 
                           data-index="${index}">
                </td>
                <td data-label="Total:" class="total-produs">${itemTotal.toFixed(2)} RON</td>
                <td data-label="Actiuni:">
                    <button class="buton-sterge" data-index="${index}">Șterge</button>
                </td>
            `;
            cartTableBody.appendChild(row);
        });

        // Actualizeaza randul cu totalul general
        const totalCell = totalRow.querySelector('.total-general');
        if (totalCell) {
             totalCell.textContent = grandTotal.toFixed(2) + " RON";
        }
       
        // Salveaza starea cosului
        saveCart();
    };


    // 3. Functie pentru adaugarea/actualizarea unui produs
    const addToCart = (productName, productPrice) => {
        const existingItem = cart.find(item => item.name === productName);

        if (existingItem) {
            existingItem.quantity += 1; 
        } else {
            cart.push({
                name: productName,
                price: parseFloat(productPrice),
                quantity: 1
            });
        }
        
        // Nu actualizam afisajul aici, doar salvam si alertam
        saveCart(); 
        alert(`${productName} a fost adăugat în coș!`);
    };

    // 4. Gestioneaza evenimentul de click pe butonul "Adauga in Cos"
    // Atasam evenimentul la document.body pentru a functiona pe orice pagina (pagina fond de ten.html)
    document.body.addEventListener('click', (event) => {
        if (event.target.classList.contains('buton-cos-produs')) {
            const button = event.target;
            
            // Gaseste link-ul parinte, care contine numele
            const productLink = button.closest('.produs-card').querySelector('a');
            
            if (productLink) {
                // Preia numele produsului: textul imediat dupa <br>
                const productNameNode = Array.from(productLink.childNodes).find(node => 
                    node.nodeType === 3 && node.textContent.trim().length > 0
                );
                
                const productName = productNameNode ? productNameNode.textContent.trim() : 'Produs Necunoscut';
                const productPrice = button.getAttribute('data-pret');

                if (productName && productPrice) {
                    addToCart(productName, productPrice);
                }
            }
        }
    });

    // 5. Gestioneaza evenimentele in pagina Cosului de Cumparaturi (Daca suntem in ea)
    if (cartTableBody) {
        // A. Schimbarea Cantitatii
        cartTableBody.addEventListener('change', (event) => {
            if (event.target.classList.contains('camp-cantitate')) {
                const input = event.target;
                const index = parseInt(input.getAttribute('data-index'));
                const newQuantity = parseInt(input.value);

                if (newQuantity > 0 && index >= 0 && index < cart.length) {
                    cart[index].quantity = newQuantity;
                    updateCartDisplay();
                } else if (newQuantity <= 0) {
                    input.value = 1;
                    cart[index].quantity = 1;
                    updateCartDisplay();
                }
            }
        });
        
        // B. Butonul Sterge
        cartTableBody.addEventListener('click', (event) => {
            if (event.target.classList.contains('buton-sterge')) {
                const button = event.target;
                const index = parseInt(button.getAttribute('data-index'));

                if (index >= 0 && index < cart.length) {
                    cart.splice(index, 1);
                    updateCartDisplay();
                }
            }
        });
    }

    // 6. Incarca vizualizarea cosului la incarcarea paginii Cos (daca e cazul)
    updateCartDisplay();
});