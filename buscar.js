document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.querySelector('.hamburger');
    const nav = document.querySelector('nav');
    const cartCounter = document.getElementById('contadorCarrito');
    const totalPrecio = document.getElementById('totalPrecio');

    function updateCartDisplay(items) {
        let totalItems = 0;
        let totalPrice = 0.00;

        items.forEach(item => {
            totalItems += parseInt(item.cantidad);
            totalPrice += parseFloat(item.precio) * parseInt(item.cantidad);
        });

        cartCounter.textContent = totalItems;
        totalPrecio.textContent = totalPrice.toFixed(2) + ' €';

        const addToCartButtons = document.querySelectorAll('.carro');
        addToCartButtons.forEach(button => {
            const productId = button.getAttribute('data-product-id');
            const itemInCart = items.find(item => item.id_producto == productId);
            if (itemInCart) {
                button.classList.add('added');
                button.textContent = 'Eliminar del carrito';
            } else {
                button.classList.remove('added');
                button.textContent = 'Añadir al carrito';
            }
        });
    }

    function initializeButtons() {
        const addToCartButtons = document.querySelectorAll('.carro');
        addToCartButtons.forEach(button => {
            button.removeEventListener('click', handleCartClick);
            button.addEventListener('click', handleCartClick);
        });
    }

    function handleCartClick() {
        if (!document.body.classList.contains('logged-in')) {
            alert('Debes registrarte o entrar como usuario para crear un carrito de compra');
            return;
        }

        const productId = this.getAttribute('data-product-id');
        const action = this.classList.contains('added') ? 'remove' : 'add';
        const precio = this.getAttribute('data-precio');
        const cantidadInput = document.getElementById('cantidad');
        const cantidad = cantidadInput ? cantidadInput.value : 1;

        console.log('Product ID:', productId);
        console.log('Action:', action);
        console.log('Precio:', precio);
        console.log('Cantidad:', cantidad);

        if (!productId || !precio) {
            console.error('Error: productId o precio no definidos.');
            return;
        }

        fetch('update_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ productId, action, precio, cantidad })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                updateCartDisplay(data.items);
            } else {
                console.error('Error updating cart:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    hamburger.addEventListener('click', function () {
        nav.classList.toggle('active');
    });

    function fetchCartAndInitializeButtons() {
        fetch('get_cart.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    updateCartDisplay(data.items);
                    initializeButtons();
                } else {
                    console.error('Error fetching cart:', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    fetchCartAndInitializeButtons();

    const params = new URLSearchParams(window.location.search);
    const query = params.get('q') ? params.get('q').toLowerCase().trim() : "";

    if (query) {
        fetch(`buscar_productos.php?q=${encodeURIComponent(query)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const productos = data;
                const resultadosDiv = document.getElementById('resultados');
                resultadosDiv.innerHTML = ""; // Limpiar resultados anteriores
                if (productos.length > 0) {
                    productos.forEach(producto => {
                        const prodDiv = document.createElement('div');
                        prodDiv.className = 'producto';
                        prodDiv.innerHTML = `
                            <h2>${producto.nombre}</h2>
                            <a href="detalle_producto.php?id=${producto.id_producto}">
                                <img src="${producto.imagen}" alt="${producto.nombre}">
                            </a>
                            <p>Precio: ${producto.precio}€</p>
                            <button class="carro" data-precio="${producto.precio.replace('€', '')}" data-product-id="${producto.id_producto}">Añadir al carrito</button>
                        `;
                        resultadosDiv.appendChild(prodDiv);
                    });

                    // Inicializar botones después de agregar productos al DOM
                    initializeButtons();
                } else {
                    resultadosDiv.innerHTML = "<p>No se encontraron productos que coincidan con la búsqueda.</p>";
                }
            })
            .catch(error => {
                console.error('Error al buscar productos:', error);
            });
    } else {
        initializeButtons();
    }
});








