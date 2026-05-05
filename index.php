<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nordic Leather | Мастерская изделий из кожи</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Roboto+Mono&display=swap');
        body { background-color: #0f0f0f; color: #e7e5e4; font-family: 'Playfair Display', serif; }
        .font-mono { font-family: 'Roboto Mono', monospace; }
    </style>
</head>
<body>

    <!-- Навигация -->
    <nav class="sticky top-0 z-50 bg-black/90 backdrop-blur-md border-b border-stone-800 p-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold tracking-[0.3em] uppercase text-[#c27854]">Nordic Leather</h1>
            <button onclick="toggleCart()" class="border border-stone-700 px-6 py-2 rounded-full hover:bg-[#c27854] hover:text-white transition duration-300">
                Корзина (<span id="cart-count">0</span>)
            </button>
        </div>
    </nav>

    <!-- Hero -->
    <header class="py-24 text-center px-4">
        <h2 class="text-6xl mb-6">Честная кожа. Ручной шов.</h2>
        <p class="text-stone-500 italic max-w-lg mx-auto">Создаем аксессуары из натуральной кожи, которые стареют красиво и служат десятилетиями.</p>
    </header>

    <!-- Сетка товаров -->
    <main class="max-w-7xl mx-auto pb-20 px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12" id="products-list">
            <!-- Товары добавятся через JavaScript -->
        </div>
    </main>

    <!-- Виджет Корзины (справа) -->
    <div id="cart-drawer" class="fixed inset-0 z-[100] translate-x-full transition-transform duration-500">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="toggleCart()"></div>
        <div class="absolute right-0 top-0 h-full w-full max-w-md bg-stone-900 p-8 shadow-2xl flex flex-col border-l border-stone-800">
            <div class="flex justify-between items-center mb-10">
                <h2 class="text-3xl">Ваш заказ</h2>
                <button onclick="toggleCart()" class="text-3xl text-stone-500">&times;</button>
            </div>
            <div id="cart-items" class="flex-1 overflow-y-auto space-y-6">
                <!-- Сюда упадут товары -->
            </div>
            <div class="pt-8 border-t border-stone-800 mt-4">
                <div class="flex justify-between text-xl mb-6">
                    <span>Итого:</span>
                    <span id="cart-total" class="font-mono text-[#c27854]">0 ₽</span>
                </div>
                <button onclick="alert('Переходим к PHP оформлению!')" class="w-full bg-[#c27854] py-4 font-bold uppercase tracking-widest hover:bg-orange-700 transition">
                    Оформить
                </button>
            </div>
        </div>
    </div>

    <script>
        // Данные (потом это будет отдавать PHP из MySQL)
        const products = [
            { id: 1, name: 'Ремень Classic', price: 4500, img: 'https://images.unsplash.com/photo-1624222247344-550fb8ec973d?q=80&w=500' },
            { id: 2, name: 'Кошелек Bifold', price: 5800, img: 'https://images.unsplash.com/photo-1627123424574-724758594e93?q=80&w=500' },
            { id: 3, name: 'Сумка Messenger', price: 12500, img: 'https://images.unsplash.com/photo-1547949003-9792a18a2601?q=80&w=500' }
        ];

        let cart = [];

        // Рендер товаров
        const productsList = document.getElementById('products-list');
        products.forEach(p => {
            productsList.innerHTML += `
                <div class="group border border-stone-800 p-4 rounded-2xl hover:border-[#c27854]/50 transition duration-500">
                    <img src="${p.img}" class="w-full h-72 object-cover rounded-xl mb-6 grayscale hover:grayscale-0 transition duration-700">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-2xl">${p.name}</h3>
                        <span class="font-mono text-[#c27854] text-xl">${p.price} ₽</span>
                    </div>
                    <button onclick="addToCart(${p.id})" class="w-full mt-6 border border-stone-700 py-3 uppercase text-xs tracking-widest hover:bg-white hover:text-black transition">Добавить</button>
                </div>
            `;
        });

        function toggleCart() {
            document.getElementById('cart-drawer').classList.toggle('translate-x-full');
        }

        function addToCart(id) {
            const product = products.find(p => p.id === id);
            cart.push(product);
            updateCart();
        }

        function updateCart() {
            document.getElementById('cart-count').innerText = cart.length;
            const itemsContainer = document.getElementById('cart-items');
            const totalElement = document.getElementById('cart-total');
            
            itemsContainer.innerHTML = '';
            let total = 0;

            cart.forEach((item, index) => {
                total += item.price;
                itemsContainer.innerHTML += `
                    <div class="flex gap-4 items-center">
                        <img src="${item.img}" class="w-16 h-16 object-cover rounded">
                        <div class="flex-1">
                            <h4 class="font-bold">${item.name}</h4>
                            <p class="text-xs text-[#c27854]">${item.price} ₽</p>
                        </div>
                        <button onclick="removeFromCart(${index})" class="text-stone-600">&times;</button>
                    </div>
                `;
            });
            totalElement.innerText = total + ' ₽';
        }

        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCart();
        }
    </script>
</body>
</html>