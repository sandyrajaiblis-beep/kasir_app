<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS UMKM - Point of Sale System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
        }

        .header .info {
            text-align: right;
            font-size: 14px;
        }

        .main-content {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 0;
            min-height: calc(100vh - 150px);
        }

        .products-section {
            padding: 30px;
            border-right: 2px solid #e0e0e0;
        }

        .search-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search-bar input {
            flex: 1;
            padding: 12px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
        }

        .search-bar input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-bar select {
            padding: 12px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            cursor: pointer;
            background: white;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 15px;
            max-height: calc(100vh - 300px);
            overflow-y: auto;
            padding-right: 10px;
        }

        .product-card {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            border-color: #667eea;
        }

        .product-card.low-stock {
            border-color: #ff6b6b;
            background: #fff5f5;
        }

        .product-card .name {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 5px;
            color: #333;
        }

        .product-card .category {
            font-size: 11px;
            color: #666;
            margin-bottom: 8px;
        }

        .product-card .price {
            font-size: 16px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 5px;
        }

        .product-card .stock {
            font-size: 12px;
            color: #999;
        }

        .product-card .stock.low {
            color: #ff6b6b;
            font-weight: 600;
        }

        .cart-section {
            background: #f8f9fa;
            padding: 30px;
            display: flex;
            flex-direction: column;
        }

        .cart-header {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            margin-bottom: 20px;
            max-height: 400px;
        }

        .cart-item {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .cart-item .item-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .cart-item .item-name {
            font-weight: 600;
            color: #333;
        }

        .cart-item .item-remove {
            color: #ff6b6b;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
        }

        .cart-item .item-controls {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-control button {
            width: 30px;
            height: 30px;
            border: none;
            background: #667eea;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
        }

        .quantity-control button:active {
            transform: scale(0.95);
        }

        .quantity-control span {
            min-width: 30px;
            text-align: center;
            font-weight: 600;
        }

        .item-price {
            font-weight: 600;
            color: #667eea;
        }

        .cart-summary {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .summary-row.total {
            font-size: 18px;
            font-weight: 700;
            color: #667eea;
            padding-top: 10px;
            border-top: 2px solid #e0e0e0;
            margin-top: 10px;
        }

        .checkout-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .checkout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .checkout-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 15px;
            padding: 30px;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }

        .modal-buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-secondary {
            background: #e0e0e0;
            color: #333;
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            z-index: 2000;
            animation: slideIn 0.3s ease;
            display: none;
        }

        .notification.success {
            background: #51cf66;
        }

        .notification.error {
            background: #ff6b6b;
        }

        .notification.show {
            display: block;
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .empty-cart {
            text-align: center;
            padding: 40px 20px;
            color: #999;
        }

        .empty-cart-icon {
            font-size: 60px;
            margin-bottom: 15px;
        }

        @media (max-width: 1024px) {
            .main-content {
                grid-template-columns: 1fr;
            }

            .products-section {
                border-right: none;
                border-bottom: 2px solid #e0e0e0;
            }
        }

        @media (max-width: 768px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }

            .header h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🛒 POS UMKM</h1>
            <div class="info">
                <div>Kasir: <strong>Admin</strong></div>
                <div id="currentDate"></div>
            </div>
        </div>

        <div class="main-content">
            <div class="products-section">
                <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="🔍 Cari produk...">
                    <select id="categoryFilter">
                        <option value="">Semua Kategori</option>
                    </select>
                </div>

                <div class="products-grid" id="productsGrid">
                    <!-- Products will be loaded here -->
                </div>
            </div>

            <div class="cart-section">
                <div class="cart-header">🛍️ Keranjang Belanja</div>
                
                <div class="cart-items" id="cartItems">
                    <div class="empty-cart">
                        <div class="empty-cart-icon">🛒</div>
                        <div>Keranjang masih kosong</div>
                    </div>
                </div>

                <div class="cart-summary">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span id="subtotal">Rp 0</span>
                    </div>
                    <div class="summary-row">
                        <span>Diskon:</span>
                        <span id="discount">Rp 0</span>
                    </div>
                    <div class="summary-row total">
                        <span>TOTAL:</span>
                        <span id="total">Rp 0</span>
                    </div>
                </div>

                <button class="checkout-btn" id="checkoutBtn" disabled>
                    Checkout
                </button>
            </div>
        </div>
    </div>

    <!-- Checkout Modal -->
    <div class="modal" id="checkoutModal">
        <div class="modal-content">
            <div class="modal-header">💳 Checkout</div>
            
            <div class="form-group">
                <label>Pelanggan</label>
                <select id="customerSelect">
                    <option value="1">Umum</option>
                </select>
            </div>

            <div class="form-group">
                <label>Metode Pembayaran</label>
                <select id="paymentMethod">
                    <option value="tunai">Tunai</option>
                    <option value="debit">Kartu Debit</option>
                    <option value="kredit">Kartu Kredit</option>
                    <option value="qris">QRIS</option>
                    <option value="transfer">Transfer Bank</option>
                </select>
            </div>

            <div class="form-group">
                <label>Total Bayar</label>
                <input type="text" id="totalDisplay" disabled>
            </div>

            <div class="form-group">
                <label>Catatan (Opsional)</label>
                <input type="text" id="notes" placeholder="Catatan transaksi...">
            </div>

            <div class="modal-buttons">
                <button class="btn btn-secondary" onclick="closeCheckoutModal()">Batal</button>
                <button class="btn btn-primary" onclick="processCheckout()">Proses Pembayaran</button>
            </div>
        </div>
    </div>

    <!-- Notification -->
    <div class="notification" id="notification"></div>

    <script>
        // Sample Data (Replace with actual API calls)
        let products = [
            {id_produk: 1, nama_produk: 'Mie Instan', kategori: 'Makanan', harga_jual: 3500, stok: 100, satuan: 'pcs'},
            {id_produk: 2, nama_produk: 'Air Mineral 600ml', kategori: 'Minuman', harga_jual: 3000, stok: 150, satuan: 'pcs'},
            {id_produk: 3, nama_produk: 'Teh Kotak', kategori: 'Minuman', harga_jual: 5000, stok: 80, satuan: 'pcs'},
            {id_produk: 4, nama_produk: 'Sabun Mandi', kategori: 'Toiletries', harga_jual: 8000, stok: 50, satuan: 'pcs'},
            {id_produk: 5, nama_produk: 'Shampoo Sachet', kategori: 'Toiletries', harga_jual: 2000, stok: 200, satuan: 'pcs'},
            {id_produk: 6, nama_produk: 'Kopi Sachet', kategori: 'Minuman', harga_jual: 2500, stok: 120, satuan: 'pcs'},
            {id_produk: 7, nama_produk: 'Susu UHT', kategori: 'Minuman', harga_jual: 7000, stok: 60, satuan: 'pcs'},
            {id_produk: 8, nama_produk: 'Roti Tawar', kategori: 'Makanan', harga_jual: 12000, stok: 30, satuan: 'pcs'},
            {id_produk: 9, nama_produk: 'Pasta Gigi', kategori: 'Toiletries', harga_jual: 9000, stok: 4, satuan: 'pcs'},
            {id_produk: 10, nama_produk: 'Sikat Gigi', kategori: 'Toiletries', harga_jual: 5000, stok: 45, satuan: 'pcs'}
        ];

        let cart = [];

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateDate();
            loadProducts();
            loadCategories();
            setupEventListeners();
        });

        function updateDate() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('currentDate').textContent = now.toLocaleDateString('id-ID', options);
        }

        function loadProducts(search = '', category = '') {
            const grid = document.getElementById('productsGrid');
            
            let filtered = products.filter(p => {
                const matchSearch = p.nama_produk.toLowerCase().includes(search.toLowerCase()) ||
                                  p.kategori.toLowerCase().includes(search.toLowerCase());
                const matchCategory = !category || p.kategori === category;
                return matchSearch && matchCategory;
            });

            grid.innerHTML = filtered.map(product => `
                <div class="product-card ${product.stok < 10 ? 'low-stock' : ''}" onclick="addToCart(${product.id_produk})">
                    <div class="name">${product.nama_produk}</div>
                    <div class="category">${product.kategori}</div>
                    <div class="price">Rp ${formatNumber(product.harga_jual)}</div>
                    <div class="stock ${product.stok < 10 ? 'low' : ''}">
                        Stok: ${product.stok} ${product.satuan}
                        ${product.stok < 10 ? ' ⚠️' : ''}
                    </div>
                </div>
            `).join('');
        }

        function loadCategories() {
            const categories = [...new Set(products.map(p => p.kategori))];
            const select = document.getElementById('categoryFilter');
            
            categories.forEach(cat => {
                const option = document.createElement('option');
                option.value = cat;
                option.textContent = cat;
                select.appendChild(option);
            });
        }

        function setupEventListeners() {
            document.getElementById('searchInput').addEventListener('input', function(e) {
                const category = document.getElementById('categoryFilter').value;
                loadProducts(e.target.value, category);
            });

            document.getElementById('categoryFilter').addEventListener('change', function(e) {
                const search = document.getElementById('searchInput').value;
                loadProducts(search, e.target.value);
            });

            document.getElementById('checkoutBtn').addEventListener('click', openCheckoutModal);
        }

        function addToCart(productId) {
            const product = products.find(p => p.id_produk === productId);
            
            if (!product) return;
            
            if (product.stok <= 0) {
                showNotification('Stok produk habis!', 'error');
                return;
            }

            const existingItem = cart.find(item => item.id_produk === productId);
            
            if (existingItem) {
                if (existingItem.quantity >= product.stok) {
                    showNotification('Jumlah melebihi stok tersedia!', 'error');
                    return;
                }
                existingItem.quantity++;
            } else {
                cart.push({
                    id_produk: product.id_produk,
                    nama_produk: product.nama_produk,
                    harga_satuan: product.harga_jual,
                    quantity: 1,
                    stok_tersedia: product.stok,
                    diskon: 0
                });
            }

            updateCart();
            showNotification(`${product.nama_produk} ditambahkan ke keranjang`, 'success');
        }

        function updateCart() {
            const cartItemsDiv = document.getElementById('cartItems');
            
            if (cart.length === 0) {
                cartItemsDiv.innerHTML = `
                    <div class="empty-cart">
                        <div class="empty-cart-icon">🛒</div>
                        <div>Keranjang masih kosong</div>
                    </div>
                `;
                document.getElementById('checkoutBtn').disabled = true;
            } else {
                cartItemsDiv.innerHTML = cart.map((item, index) => `
                    <div class="cart-item">
                        <div class="item-header">
                            <span class="item-name">${item.nama_produk}</span>
                            <span class="item-remove" onclick="removeFromCart(${index})">✕</span>
                        </div>
                        <div class="item-controls">
                            <div class="quantity-control">
                                <button onclick="decreaseQuantity(${index})">-</button>
                                <span>${item.quantity}</span>
                                <button onclick="increaseQuantity(${index})">+</button>
                            </div>
                            <div class="item-price">Rp ${formatNumber(item.harga_satuan * item.quantity)}</div>
                        </div>
                    </div>
                `).join('');
                document.getElementById('checkoutBtn').disabled = false;
            }

            updateSummary();
        }

        function increaseQuantity(index) {
            const item = cart[index];
            if (item.quantity >= item.stok_tersedia) {
                showNotification('Jumlah melebihi stok tersedia!', 'error');
                return;
            }
            item.quantity++;
            updateCart();
        }

        function decreaseQuantity(index) {
            const item = cart[index];
            if (item.quantity > 1) {
                item.quantity--;
                updateCart();
            }
        }

        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCart();
        }

        function updateSummary() {
            const subtotal = cart.reduce((sum, item) => sum + (item.harga_satuan * item.quantity), 0);
            const discount = cart.reduce((sum, item) => sum + (item.diskon || 0), 0);
            const total = subtotal - discount;

            document.getElementById('subtotal').textContent = `Rp ${formatNumber(subtotal)}`;
            document.getElementById('discount').textContent = `Rp ${formatNumber(discount)}`;
            document.getElementById('total').textContent = `Rp ${formatNumber(total)}`;
        }

        function openCheckoutModal() {
            if (cart.length === 0) return;
            
            const total = cart.reduce((sum, item) => sum + (item.harga_satuan * item.quantity) - (item.diskon || 0), 0);
            document.getElementById('totalDisplay').value = `Rp ${formatNumber(total)}`;
            document.getElementById('checkoutModal').classList.add('active');
        }

        function closeCheckoutModal() {
            document.getElementById('checkoutModal').classList.remove('active');
        }

        function processCheckout() {
            const customerId = document.getElementById('customerSelect').value;
            const paymentMethod = document.getElementById('paymentMethod').value;
            const notes = document.getElementById('notes').value;
            const total = cart.reduce((sum, item) => sum + (item.harga_satuan * item.quantity) - (item.diskon || 0), 0);

            // Prepare transaction data
            const transactionData = {
                id_pelanggan: customerId,
                total_bayar: total,
                metode_pembayaran: paymentMethod,
                kasir: 'Admin',
                catatan: notes,
                items: cart.map(item => ({
                    id_produk: item.id_produk,
                    quantity: item.quantity,
                    harga_satuan: item.harga_satuan,
                    subtotal: item.harga_satuan * item.quantity,
                    diskon: item.diskon || 0
                }))
            };

            // Simulate API call (replace with actual fetch to backend)
            console.log('Transaction Data:', transactionData);

            // Update stock locally
            cart.forEach(item => {
                const product = products.find(p => p.id_produk === item.id_produk);
                if (product) {
                    product.stok -= item.quantity;
                }
            });

            // Clear cart
            cart = [];
            updateCart();
            loadProducts(); // Refresh products to show updated stock

            closeCheckoutModal();
            showNotification('Transaksi berhasil! Terima kasih.', 'success');

            // Reset form
            document.getElementById('notes').value = '';
        }

        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = `notification ${type} show`;
            
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }
    </script>
</body>
</html>