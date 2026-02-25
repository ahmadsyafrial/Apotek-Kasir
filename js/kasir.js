/**
 * SISTEM KASIR APOTEK - MAIN JAVASCRIPT (FIXED)
 * Semua bug fetch + search + render sudah diperbaiki
 */

const app = {
    // ================= STATE =================
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

    // ================= INIT =================
    init() {
        console.log('App initialized');
        this.bindEvents();
        this.fetchProducts();
        this.renderCart();
    },

    // ================= EVENTS =================
    bindEvents() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') this.searchProducts();
            });
        }

        const clearBtn = document.getElementById('clearSearch');
        if (clearBtn) {
            clearBtn.addEventListener('click', () => this.clearSearch());
        }

        const cashInput = document.getElementById('cashInput');
        if (cashInput) {
            cashInput.addEventListener('input', () => this.calculateChange());
        }

        const overlay = document.getElementById('modalOverlay');
        if (overlay) {
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) this.closeModal();
            });
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') this.closeModal();
        });
    },

    // ================= FETCH PRODUCTS =================
    async fetchProducts() {
        try {
            const response = await fetch('API/products.php');
            const data = await response.json();

            if (data.error) {
                console.error('Server error:', data);
                return;
            }

            this.products = data;

            console.log('Products from DB:', data);

            const container = document.getElementById('productsContainer');
            this.renderProductsList(container, this.products);

        } catch (error) {
            console.error('Gagal ambil produk:', error);
        }
    },

    // ================= SEARCH =================
    searchProducts() {
        const input = document.getElementById('searchInput');
        const query = input ? input.value.trim().toLowerCase() : '';
        const container = document.getElementById('productsContainer');

        console.log('Searching for:', query);

        if (!query) {
            this.renderProductsList(container, this.products);
            return;
        }

        const filtered = this.products.filter(p =>
            p.name.toLowerCase().includes(query)
        );

        console.log('Found products:', filtered);

        if (filtered.length === 0) {
            this.showNotFound(container);
        } else {
            this.renderProductsList(container, filtered);
        }
    },

    clearSearch() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) searchInput.value = '';

        const clearSearch = document.getElementById('clearSearch');
        if (clearSearch) clearSearch.classList.remove('show');

        const container = document.getElementById('productsContainer');
        this.renderProductsList(container, this.products);
    },

    // ================= RENDER PRODUCTS =================
    renderProductsList(container, products = this.products) {
        if (!container) return;

        console.log('Rendering products:', products);

        const html = products.map(product => {
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

    // ================= PRODUCT CLICK =================
    handleProductClick(productId) {
        console.log('Product clicked, ID:', productId);

        const product = this.products.find(p => p.id == productId);

        if (!product) {
            console.error('Product not found!', productId);
            alert('Produk tidak ditemukan');
            return;
        }

        this.openProductModal(product);
    },

    openProductModal(product) {
        this.currentProduct = product;
        this.modalQty = 1;

        const modalHtml = `
            <div class="modal">
                <div class="modal-header">
                    <div class="modal-title">Detail Produk</div>
                    <button class="modal-close" onclick="app.closeModal()">&times;</button>
                </div>
                <div class="modal-body">
                    <p><strong>${this.escapeHtml(product.name)}</strong></p>
                    <p>Harga: Rp ${this.formatNumber(product.price)}</p>
                    <p>Stok: ${product.stock} ${product.unit}</p>

                    <div class="qty-control-modal">
                        <button onclick="app.changeModalQty(-1)">−</button>
                        <span id="modalQtyValue">1</span>
                        <button onclick="app.changeModalQty(1)">+</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="app.addToCart()">Tambah ke Transaksi</button>
                </div>
            </div>
        `;

        const overlay = document.getElementById('modalOverlay');
        overlay.innerHTML = modalHtml;
        overlay.classList.add('show');
    },

    changeModalQty(delta) {
        const newQty = this.modalQty + delta;

        if (newQty >= 1 && newQty <= this.currentProduct.stock) {
            this.modalQty = newQty;
            document.getElementById('modalQtyValue').textContent = newQty;
        }
    },

    addToCart() {
        if (!this.currentProduct) return;

        const existing = this.cart.find(i => i.id == this.currentProduct.id);

        if (existing) {
            existing.qty += this.modalQty;
        } else {
            this.cart.push({
                ...this.currentProduct,
                qty: this.modalQty
            });
        }

        this.closeModal();
        this.renderCart();
    },

    closeModal() {
        const overlay = document.getElementById('modalOverlay');
        overlay.classList.remove('show');
        overlay.innerHTML = '';
        this.currentProduct = null;
        this.modalQty = 1;
    },

    // ================= CART =================
    renderCart() {
        const container = document.getElementById('cartItems');
        if (!container) return;

        if (this.cart.length === 0) {
            container.innerHTML = `<p>Keranjang kosong</p>`;
            return;
        }

        container.innerHTML = this.cart.map(item => `
            <div>
                ${item.name} (${item.qty})
                - Rp ${this.formatNumber(item.price * item.qty)}
            </div>
        `).join('');
    },

    // ================= PAYMENT =================
    calculateChange() {
        console.log('Calculate change...');
    },

    // ================= UTILITIES =================
    formatNumber(num) {
        return Number(num).toLocaleString('id-ID');
    },

    escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    },

    showNotFound(container) {
        container.innerHTML = `
            <div class="not-found">
                <p>Produk tidak ditemukan</p>
            </div>
        `;
    }
};

// ================= START APP =================
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM loaded, initializing app...');
    app.init();
});
