document.addEventListener('DOMContentLoaded', () => {
    let cart = JSON.parse(localStorage.getItem('shoppingCart')) || [];
    const cartTableBody = document.querySelector('.tabel-cos tbody');
    const totalRow = document.querySelector('.rand-total');

    const saveCart = () => {
        localStorage.setItem('shoppingCart', JSON.stringify(cart));
    };

    const updateCartDisplay = () => {
        if (!cartTableBody || !totalRow) return; 
        cartTableBody.innerHTML = '';
        let grandTotal = 0;

        cart.forEach((item, index) => {
            const row = document.createElement('tr');
            row.classList.add('articol-cos'); 
            const itemTotal = item.price * item.quantity;
            grandTotal += itemTotal;

            row.innerHTML = `
                <td data-label="Produs:">${item.name}</td>
                <td data-label="Preț Unitar:">${item.price.toFixed(2)} RON</td>
                <td data-label="Cantitate:">
                    <input type="number" class="camp-cantitate" value="${item.quantity}" min="1" data-index="${index}">
                </td>
                <td data-label="Total:" class="total-produs">${itemTotal.toFixed(2)} RON</td>
                <td data-label="Actiuni:">
                    <button class="buton-sterge" data-index="${index}">Sterge</button>
                </td>
            `;
            cartTableBody.appendChild(row);
        });

        const totalCell = totalRow.querySelector('.total-general');
        if (totalCell) totalCell.textContent = grandTotal.toFixed(2) + " RON";
        saveCart();
    };

    const addToCart = (productId, productName, productPrice) => {
        const existingItem = cart.find(item => item.id === productId);

        if (existingItem) {
            existingItem.quantity += 1; 
        } else {
            cart.push({
                id: productId,
                name: productName,
                price: parseFloat(productPrice),
                quantity: 1
            });
        }
        saveCart(); 
        alert(`${productName} a fost adaugat in cos!`);
    };

    document.body.addEventListener('click', (event) => {
        if (event.target.classList.contains('buton-cos-produs')) {
            const button = event.target;
            const productLink = button.closest('.produs-card').querySelector('a');
            
            if (productLink) {
                const productNameNode = Array.from(productLink.childNodes).find(node => 
                    node.nodeType === 3 && node.textContent.trim().length > 0
                );
                
                const productName = productNameNode ? productNameNode.textContent.trim() : 'Produs';
                const productPrice = button.getAttribute('data-pret');
                const productId = button.getAttribute('data-id');

                if (productId && productPrice) {
                    addToCart(productId, productName, productPrice);
                }
            }
        }
    });

    if (cartTableBody) {
        cartTableBody.addEventListener('change', (event) => {
            if (event.target.classList.contains('camp-cantitate')) {
                const index = parseInt(event.target.getAttribute('data-index'));
                const newQuantity = parseInt(event.target.value);
                if (newQuantity > 0) {
                    cart[index].quantity = newQuantity;
                } else {
                    cart[index].quantity = 1;
                }
                updateCartDisplay();
            }
        });
        
        cartTableBody.addEventListener('click', (event) => {
            if (event.target.classList.contains('buton-sterge')) {
                const index = parseInt(event.target.getAttribute('data-index'));
                cart.splice(index, 1);
                updateCartDisplay();
            }
        });
    }

    updateCartDisplay();
});