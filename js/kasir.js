/**
 * SISTEM KASIR APOTEK - MAIN JAVASCRIPT (FIXED VERSION 3)
 * Semua method ada di dalam object app
 */

const app = {
    // State
    cart: [],
    products: [],
    currentProduct: null,
    modalQty: 1,
    memberType: 'non-member',
    currentMember: null,
    paymentMethod: 'cash',
    lastDeletedItem: null,
    isProcessing: false,
    qtyChangeInterval: null,

    /**
     * Initialize - HANYA INI yang dipanggil saat DOM ready
     */
    init() {
        console.log('App initialized');
        this.bindEvents();
        
        // Render state awal
        this.renderCart();
    },

    /**
     * Bind semua event listeners
     */
    bindEvents() {
        // Search input
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') this.searchProducts();
            });
        }

        // Clear search button
        const clearBtn = document.getElementById('clearSearch');
        if (clearBtn) {
            clearBtn.addEventListener('click', () => this.clearSearch());
        }

        // Cash input
        const cashInput = document.getElementById('cashInput');
        if (cashInput) {
            cashInput.addEventListener('input', () => this.calculateChange());
        }

        // Modal overlay
        const overlay = document.getElementById('modalOverlay');
        if (overlay) {
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) this.closeModal();
            });
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') this.closeModal();
        });
    },

    /* ==========================================
       SEARCH PRODUCTS
       ========================================== */

    searchProducts() {
        const input = document.getElementById('searchInput');
        const query = input ? input.value.trim().toLowerCase() : '';
        const container = document.getElementById('productsContainer');

        console.log('Searching for:', query);

        if (!query) {
            this.showEmptyState(container);
            return;
        }

        // Sample data
        const allProducts = [
            { id: 1, name: 'Paracetamol 500mg', price: 15000, stock: 50, unit: 'Strip' },
            { id: 2, name: 'Amoxicillin 500mg', price: 25000, stock: 30, unit: 'Strip' },
            { id: 3, name: 'Vitamin C 1000mg', price: 35000, stock: 0, unit: 'Botol' },
            { id: 4, name: 'Antasida Doen', price: 12000, stock: 100, unit: 'Strip' },
            { id: 5, name: 'Betadine 30ml', price: 28000, stock: 25, unit: 'Botol' },
            { id: 6, name: 'Salep Kulit 5g', price: 18500, stock: 40, unit: 'Tube' },
            { id: 7, name: 'Obat Batuk Sirup', price: 42000, stock: 15, unit: 'Botol' },
            { id: 8, name: 'Aspirin 80mg', price: 8000, stock: 60, unit: 'Strip' },
        ];

        // Filter dan simpan ke state
        this.products = allProducts.filter(p => p.name.toLowerCase().includes(query));
        
        console.log('Found products:', this.products);

        if (this.products.length === 0) {
            this.showNotFound(container);
        } else {
            this.renderProductsList(container);
        }
    },

    /**
     * Render daftar produk ke grid
     */
    renderProductsList(container) {
        console.log('Rendering products:', this.products);

        const html = this.products.map(product => {
            const isOutOfStock = product.stock === 0;
            return `
                <div class="product-card ${isOutOfStock ? 'disabled' : ''}">
                    <div class="product-name">${this.escapeHtml(product.name)}</div>
                    <div class="product-price">Rp ${this.formatNumber(product.price)}</div>
                    <div class="product-stock">Stok: ${product.stock} ${product.unit}</div>
                    ${!isOutOfStock ? `
                        <button class="add-to-cart-btn" 
                                onclick="app.handleProductClick(${product.id})"
                                type="button">
                            🛒
                        </button>
                    ` : '<div class="out-of-stock-label">STOK HABIS</div>'}
                </div>
            `;
        }).join('');

        container.innerHTML = html;
    },

    /**
     * Handle klik produk/tombol keranjang
     */
    handleProductClick(productId) {
        console.log('Product clicked, ID:', productId);
        
        // Cari produk dari state
        const product = this.products.find(p => p.id === productId);
        
        if (!product) {
            console.error('Product not found! ID:', productId);
            console.log('Available products:', this.products);
            alert('Error: Produk tidak ditemukan');
            return;
        }

        console.log('Found product:', product);
        this.openProductModal(product);
    },

    /**
     * Buka modal detail produk
     */
    openProductModal(product) {
        this.currentProduct = product;
        this.modalQty = 1;

        const modalHtml = `
            <div class="modal" id="productDetailModal">
                <div class="modal-header">
                    <div class="modal-title">Detail Produk</div>
                    <button class="modal-close" onclick="app.closeModal()" type="button">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="product-detail-info">
                        <div class="detail-row">
                            <span class="detail-label">Nama Produk</span>
                            <span class="detail-value">${this.escapeHtml(product.name)}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Harga Satuan</span>
                            <span class="detail-value">Rp ${this.formatNumber(product.price)}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Stok Tersedia</span>
                            <span class="detail-value">${product.stock} ${product.unit}</span>
                        </div>
                    </div>
                    <div class="qty-control-modal">
                        <button class="qty-btn-large" onclick="app.changeModalQty(-1)" type="button">−</button>
                        <div class="qty-display-large" id="modalQtyValue">1</div>
                        <button class="qty-btn-large" onclick="app.changeModalQty(1)" type="button">+</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-add-transaction" onclick="app.addToCart()" type="button">
                        Tambah ke Transaksi
                    </button>
                </div>
            </div>
        `;

        const overlay = document.getElementById('modalOverlay');
        if (overlay) {
            overlay.innerHTML = modalHtml;
            overlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    },

    /**
     * Ubah qty di modal
     */
    changeModalQty(delta) {
        const newQty = this.modalQty + delta;
        if (newQty >= 1 && this.currentProduct && newQty <= this.currentProduct.stock) {
            this.modalQty = newQty;
            const display = document.getElementById('modalQtyValue');
            if (display) display.textContent = this.modalQty;
        }
    },

    /**
     * Tambah ke cart dari modal
     */
    addToCart() {
        console.log('Adding to cart:', this.currentProduct, 'qty:', this.modalQty);

        if (!this.currentProduct) {
            console.error('No product selected!');
            return;
        }

        const existingIndex = this.cart.findIndex(item => item.id === this.currentProduct.id);
        
        if (existingIndex >= 0) {
            // Update existing
            const newQty = this.cart[existingIndex].qty + this.modalQty;
            if (newQty > this.currentProduct.stock) {
                alert('Stok tidak mencukupi! Tersedia: ' + this.currentProduct.stock);
                return;
            }
            this.cart[existingIndex].qty = newQty;
        } else {
            // Add new
            if (this.modalQty > this.currentProduct.stock) {
                alert('Stok tidak mencukupi!');
                return;
            }
            this.cart.push({
                id: this.currentProduct.id,
                name: this.currentProduct.name,
                price: this.currentProduct.price,
                stock: this.currentProduct.stock,
                unit: this.currentProduct.unit,
                qty: this.modalQty
            });
        }

        this.closeModal();
        this.renderCart();
        this.showToast(`${this.currentProduct.name} ditambahkan (${this.modalQty} item)`);
        
        this.currentProduct = null;
        this.modalQty = 1;
    },

    /**
     * Tutup modal
     */
    closeModal() {
        const overlay = document.getElementById('modalOverlay');
        if (overlay) {
            overlay.classList.remove('show');
            overlay.innerHTML = '';
        }
        document.body.style.overflow = '';
        this.currentProduct = null;
        this.modalQty = 1;
    },

    /* ==========================================
       CART
       ========================================== */

    renderCart() {
        const container = document.getElementById('cartItems');
        const summary = document.getElementById('cartSummary');
        const payBtn = document.getElementById('btnPay');

        if (!container) {
            console.error('Cart container not found!');
            return;
        }

        if (this.cart.length === 0) {
            container.innerHTML = `
                <div class="empty-state">
                    <div class="empty-state-icon">🛒</div>
                    <p class="empty-state-text">Keranjang masih kosong</p>
                </div>
            `;
            if (summary) summary.style.display = 'none';
            if (payBtn) payBtn.disabled = true;
            return;
        }

        container.innerHTML = this.cart.map((item, index) => `
            <div class="cart-item">
                <div class="cart-item-info">
                    <div class="cart-item-name">${this.escapeHtml(item.name)}</div>
                    <div class="cart-item-price">
                        Rp ${this.formatNumber(item.price)} × ${item.qty} = 
                        Rp ${this.formatNumber(item.price * item.qty)}
                    </div>
                </div>
                <div class="cart-item-controls">
                    <button class="qty-btn" onclick="app.updateCartItemQty(${index}, -1)" type="button">−</button>
                    <span class="qty-display">${item.qty}</span>
                    <button class="qty-btn" onclick="app.updateCartItemQty(${index}, 1)" type="button">+</button>
                    <button class="remove-btn" onclick="app.removeCartItem(${index})" type="button">🗑</button>
                </div>
            </div>
        `).join('');

        if (summary) summary.style.display = 'block';
        if (payBtn) payBtn.disabled = false;

        this.updateCartSummary();
    },

    updateCartItemQty(index, delta) {
        if (index < 0 || index >= this.cart.length) return;
        
        const item = this.cart[index];
        const newQty = item.qty + delta;

        if (newQty < 1) {
            this.removeCartItem(index);
            return;
        }

        if (newQty > item.stock) {
            alert(`Stok tidak mencukupi! Tersedia: ${item.stock}`);
            return;
        }

        item.qty = newQty;
        this.renderCart();
    },

    removeCartItem(index) {
        this.lastDeletedItem = { item: {...this.cart[index]}, index };
        this.cart.splice(index, 1);
        this.renderCart();
        this.showToast('Item dihapus', true);
    },

    updateCartSummary() {
        const subtotal = this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        let discount = 0;

        if (this.memberType === 'member' && this.currentMember) {
            discount = subtotal * (this.currentMember.discount_percent / 100);
        }

        const total = subtotal - discount;

        const subtotalEl = document.getElementById('subtotal');
        const discountRow = document.getElementById('discountRow');
        const discountAmount = document.getElementById('discountAmount');
        const totalEl = document.getElementById('total');

        if (subtotalEl) subtotalEl.textContent = `Rp ${this.formatNumber(subtotal)}`;
        if (discountRow) discountRow.style.display = discount > 0 ? 'flex' : 'none';
        if (discountAmount) discountAmount.textContent = `- Rp ${this.formatNumber(discount)}`;
        if (totalEl) totalEl.textContent = `Rp ${this.formatNumber(total)}`;
    },

    /* ==========================================
       MEMBER
       ========================================== */

    setMemberType(type) {
        this.memberType = type;
        
        const btnNonMember = document.getElementById('btnNonMember');
        const btnMember = document.getElementById('btnMember');
        const memberSearch = document.getElementById('memberSearch');

        if (btnNonMember) btnNonMember.classList.toggle('active', type === 'non-member');
        if (btnMember) btnMember.classList.toggle('active', type === 'member');
        if (memberSearch) memberSearch.classList.toggle('show', type === 'member');

        if (type === 'non-member') {
            this.currentMember = null;
            const memberInfo = document.getElementById('memberInfo');
            const memberInput = document.getElementById('memberInput');
            if (memberInfo) {
                memberInfo.classList.remove('show');
                memberInfo.innerHTML = '';
            }
            if (memberInput) memberInput.value = '';
        }

        this.updateCartSummary();
    },

    searchMember() {
        const input = document.getElementById('memberInput');
        const query = input ? input.value.trim() : '';
        
        if (!query) return;

        const members = [
            { id: 1, name: 'Budi Santoso', phone: '08123456789', discount_percent: 10 },
            { id: 2, name: 'Ani Wijaya', phone: '08234567890', discount_percent: 10 },
        ];

        const member = members.find(m => 
            m.name.toLowerCase().includes(query.toLowerCase()) || 
            m.phone.includes(query)
        );

        const memberInfo = document.getElementById('memberInfo');
        
        if (member) {
            this.currentMember = member;
            if (memberInfo) {
                memberInfo.innerHTML = `
                    <strong>✓ Member Ditemukan</strong><br>
                    ${this.escapeHtml(member.name)} | ${member.phone}<br>
                    Diskon: ${member.discount_percent}%
                `;
                memberInfo.className = 'member-info success show';
            }
            this.updateCartSummary();
        } else {
            if (memberInfo) {
                memberInfo.innerHTML = `
                    <strong>✗ Member tidak ditemukan</strong><br>
                    <a href="#" onclick="app.setMemberType('non-member'); return false;" style="color: #667eea;">
                        Lanjutkan sebagai Non-member
                    </a>
                `;
                memberInfo.className = 'member-info error show';
            }
            this.currentMember = null;
        }
    },

    /* ==========================================
       PAYMENT
       ========================================== */

    selectPayment(method) {
        this.paymentMethod = method;
        
        document.querySelectorAll('.payment-method').forEach((el, i) => {
            const methods = ['cash', 'transfer', 'ewallet'];
            el.classList.toggle('active', methods[i] === method);
        });

        const cashContainer = document.getElementById('cashInputContainer');
        const digitalStatus = document.getElementById('digitalPaymentStatus');
        const payBtn = document.getElementById('btnPay');

        if (cashContainer) cashContainer.classList.toggle('show', method === 'cash');
        if (digitalStatus) digitalStatus.classList.toggle('show', method !== 'cash');

        if (method !== 'cash') {
            if (payBtn) {
                payBtn.textContent = 'Proses Pembayaran';
                payBtn.disabled = true;
            }
            if (digitalStatus) {
                digitalStatus.innerHTML = `
                    <div class="status-icon status-waiting">⏳</div>
                    <div>Menunggu Pembayaran</div>
                    <button class="confirm-payment-btn" onclick="app.confirmDigitalPayment()" type="button">
                        Konfirmasi Pembayaran
                    </button>
                `;
            }
        } else {
            if (payBtn) {
                payBtn.textContent = 'Bayar';
                this.calculateChange(); // Check if can enable
            }
        }
    },

    calculateChange() {
        const cashInput = document.getElementById('cashInput');
        const cash = parseFloat(cashInput ? cashInput.value : 0) || 0;
        
        const subtotal = this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        const discount = (this.memberType === 'member' && this.currentMember) ? 
            subtotal * (this.currentMember.discount_percent / 100) : 0;
        const total = subtotal - discount;

        const changeDisplay = document.getElementById('changeDisplay');
        const payBtn = document.getElementById('btnPay');

        if (changeDisplay) {
            if (cash >= total) {
                changeDisplay.classList.add('show');
                document.getElementById('changeAmount').textContent = 
                    `Rp ${this.formatNumber(cash - total)}`;
                if (payBtn) payBtn.disabled = false;
            } else {
                changeDisplay.classList.remove('show');
                if (payBtn) payBtn.disabled = true;
            }
        }
    },

    confirmDigitalPayment() {
        const digitalStatus = document.getElementById('digitalPaymentStatus');
        const payBtn = document.getElementById('btnPay');
        
        if (digitalStatus) {
            digitalStatus.innerHTML = `
                <div class="status-icon status-success">✓</div>
                <div>Pembayaran Berhasil!</div>
            `;
        }
        if (payBtn) {
            payBtn.disabled = false;
            payBtn.textContent = 'Bayar';
        }
    },

    processPayment() {
        if (this.cart.length === 0) return;
        
        // Validasi stok
        for (let item of this.cart) {
            if (item.qty > item.stock) {
                alert(`Stok ${item.name} tidak mencukupi!`);
                return;
            }
        }

        const subtotal = this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        const discount = (this.memberType === 'member' && this.currentMember) ? 
            subtotal * (this.currentMember.discount_percent / 100) : 0;
        const total = subtotal - discount;

        const receipt = this.generateReceipt(subtotal, discount, total);
        
        const overlay = document.getElementById('modalOverlay');
        if (overlay) {
            overlay.innerHTML = `
                <div class="modal">
                    <div class="modal-header">
                        <div class="modal-title">Struk Pembayaran</div>
                        <button class="modal-close" onclick="app.closeModal()" type="button">&times;</button>
                    </div>
                    <div class="modal-body" style="padding: 0;">
                        ${receipt}
                    </div>
                    <div class="modal-footer">
                        <button class="btn-add-transaction" onclick="app.printReceipt()" type="button">
                            🖨️ Cetak Struk
                        </button>
                        <button class="btn btn-secondary" onclick="app.closeModal(); app.newTransaction();" type="button">
                            Transaksi Baru
                        </button>
                    </div>
                </div>
            `;
            overlay.classList.add('show');
        }
    },

    generateReceipt(subtotal, discount, total) {
        const now = new Date();
        const items = this.cart.map(item => `
            <div class="receipt-item">
                <span>${this.escapeHtml(item.name)} (${item.qty}x)</span>
                <span>Rp ${this.formatNumber(item.price * item.qty)}</span>
            </div>
        `).join('');

        return `
            <div class="receipt">
                <div class="receipt-header">
                    <h2>APOTEK SEHAT</h2>
                    <p>Jl. Kesehatan No. 123</p>
                    <p>${now.toLocaleString('id-ID')}</p>
                </div>
                <div class="receipt-items">${items}</div>
                <div class="receipt-footer">
                    <div class="receipt-item"><span>Subtotal</span><span>Rp ${this.formatNumber(subtotal)}</span></div>
                    ${discount > 0 ? `<div class="receipt-item"><span>Diskon</span><span>- Rp ${this.formatNumber(discount)}</span></div>` : ''}
                    <div class="receipt-item total"><span>TOTAL</span><span>Rp ${this.formatNumber(total)}</span></div>
                </div>
            </div>
        `;
    },

    printReceipt() {
        const receipt = document.querySelector('.receipt');
        if (!receipt) return;

        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
            <head>
                <title>Struk</title>
                <style>
                    body { font-family: monospace; font-size: 12px; width: 80mm; margin: 0 auto; padding: 10px; }
                    .receipt-header { text-align: center; border-bottom: 1px dashed #000; padding-bottom: 10px; margin-bottom: 10px; }
                    .receipt-item { display: flex; justify-content: space-between; margin: 5px 0; }
                    .total { font-weight: bold; border-top: 1px dashed #000; padding-top: 10px; margin-top: 10px; }
                </style>
            </head>
            <body>${receipt.innerHTML}</body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    },

    newTransaction() {
        this.cart = [];
        this.currentMember = null;
        this.memberType = 'non-member';
        this.paymentMethod = 'cash';
        this.lastDeletedItem = null;
        
        // Reset UI
        const searchInput = document.getElementById('searchInput');
        if (searchInput) searchInput.value = '';
        
        const clearSearch = document.getElementById('clearSearch');
        if (clearSearch) clearSearch.classList.remove('show');
        
        this.products = [];
        
        const productsContainer = document.getElementById('productsContainer');
        if (productsContainer) {
            this.showEmptyState(productsContainer);
        }
        
        this.setMemberType('non-member');
        this.selectPayment('cash');
        
        const cashInput = document.getElementById('cashInput');
        if (cashInput) cashInput.value = '';
        
        const changeDisplay = document.getElementById('changeDisplay');
        if (changeDisplay) changeDisplay.classList.remove('show');
        
        this.renderCart();
        this.showToast('Transaksi baru dimulai');
    },

    /* ==========================================
       UTILITIES
       ========================================== */

    formatNumber(num) {
        return num.toLocaleString('id-ID');
    },

    escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    },

    showToast(message, showUndo = false) {
        // Simple alert untuk sekarang, bisa diganti dengan toast yang lebih baik
        if (showUndo) {
            if (confirm(message + '\n\nKlik OK untuk undo')) {
                this.undoLastAction();
            }
        } else {
            // Buat toast sederhana
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            if (toast && toastMessage) {
                toastMessage.textContent = message;
                toast.classList.add('show');
                setTimeout(() => toast.classList.remove('show'), 3000);
            } else {
                console.log(message);
            }
        }
    },

    undoLastAction() {
        if (this.lastDeletedItem) {
            this.cart.splice(this.lastDeletedItem.index, 0, this.lastDeletedItem.item);
            this.lastDeletedItem = null;
            this.renderCart();
        }
    },

    showEmptyState(container) {
        if (!container) return;
        container.innerHTML = `
            <div class="empty-state" style="grid-column: 1/-1;">
                <div class="empty-state-icon">🔍</div>
                <p class="empty-state-text">Ketik nama produk dan tekan Enter untuk mencari</p>
            </div>
        `;
    },

    showNotFound(container) {
        if (!container) return;
        container.innerHTML = `
            <div class="not-found" style="grid-column: 1/-1;">
                <div class="empty-state-icon">😕</div>
                <p>Produk tidak ditemukan</p>
                <button class="reset-btn" onclick="app.clearSearch()" type="button">Reset Pencarian</button>
            </div>
        `;
    },

    clearSearch() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) searchInput.value = '';
        
        const clearSearch = document.getElementById('clearSearch');
        if (clearSearch) clearSearch.classList.remove('show');
        
        this.products = [];
        
        const container = document.getElementById('productsContainer');
        this.showEmptyState(container);
    }
};

// INISIALISASI - Pastikan ini di akhir file dan tidak ada kode lain setelahnya
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing app...');
    app.init();
});