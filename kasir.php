<?php
include "Layout/sidebar.php";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Sehat - Dashboard Admin</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/kasir.css">
</head>

<body>
    <!-- Main Content -->
    <main class="main-content">


        <!-- Content Area -->
        <div class="content-area">

            <div class="container">
                <header class="topbar-kasir">
                    <div class="logo">Sistem Kasir Apotek</div>
                    <div class="header-info">
                        <div class="datetime" id="datetime"></div>
                        <button class="btn-new-transaction" onclick="app.newTransaction()">
                            🔄 Transaksi Baru
                        </button>
                    </div>
                </header>

                <div class="main-layout">
                    <div class="left-panel">
                        <div class="search-section">
                            <div class="search-container">
                                <input
                                    type="text"
                                    class="search-input"
                                    id="searchInput"
                                    placeholder="Cari produk (ketik nama produk dan tekan Enter)...">
                                <button class="clear-search" id="clearSearch" onclick="app.clearSearch()">❌</button>
                                <button class="search-btn" onclick="app.searchProducts()">Cari</button>
                            </div>
                        </div>

                        <div class="products-grid">
                            <div class="section-title">📦 Daftar Produk</div>
                            <div class="products-container" id="productsContainer">
                                <div class="empty-state">
                                    <div class="empty-state-icon">🔍</div>
                                    <p>Ketik nama produk dan tekan Enter untuk mencari</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="right-panel">
                        <div class="cart-section">
                            <div class="section-title">🛒 Detail Transaksi</div>
                            <div class="cart-items" id="cartItems">
                                <div class="empty-state">
                                    <div class="empty-state-icon">🛒</div>
                                    <p>Keranjang masih kosong</p>
                                </div>
                            </div>
                            <div class="cart-summary" id="cartSummary" style="display: none;">
                                <div class="summary-row">
                                    <span>Subtotal</span>
                                    <span id="subtotal">Rp 0</span>
                                </div>
                                <div class="summary-row discount" id="discountRow" style="display: none;">
                                    <span>Diskon Member</span>
                                    <span id="discountAmount">- Rp 0</span>
                                </div>
                                <div class="summary-row total">
                                    <span>TOTAL</span>
                                    <span id="total">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <div class="payment-section">
                            <div class="section-title">💳 Pembayaran</div>
                            <div class="payment-methods">
                                <div class="payment-method active" onclick="app.selectPayment('cash')">
                                    <span>💵</span>
                                    <div>Tunai</div>
                                </div>
                                <div class="payment-method" onclick="app.selectPayment('transfer')">
                                    <span>🏦</span>
                                    <div>Transfer</div>
                                </div>
                                <div class="payment-method" onclick="app.selectPayment('ewallet')">
                                    <span>📱</span>
                                    <div>E-Wallet</div>
                                </div>

                                <div class="member-section">
                                    <div class="member-toggle">
                                        <button class="toggle-btn active" id="btnNonMember" onclick="app.setMemberType('non-member')">Non-Member</button>
                                        <button class="toggle-btn" id="btnMember" onclick="app.setMemberType('member')">Member</button>
                                    </div>
                                    <div class="member-search" id="memberSearch">
                                        <input
                                            type="text"
                                            class="member-input"
                                            id="memberInput"
                                            placeholder="Nama / No HP Member"
                                            onkeypress="app.searchMemberKeypress(event)">
                                        <button class="search-btn-member" onclick="app.searchMember()">Cari</button>
                                    </div>
                                </div>
                                <div class="member-info" id="memberInfo"></div>
                            </div>

                            <div class="cash-input-container" id="cashInputContainer">
                                <input
                                    type="number"
                                    class="cash-input"
                                    id="cashInput"
                                    placeholder="Jumlah Bayar"
                                    oninput="app.calculateChange()">
                                <div class="change-display" id="changeDisplay">
                                    Kembalian: <span id="changeAmount">Rp 0</span>
                                </div>
                            </div>

                            <div class="digital-payment-status" id="digitalPaymentStatus">
                                <div class="status-icon status-waiting">⏳</div>
                                <div>Menunggu Pembayaran</div>
                                <button class="confirm-payment-btn" onclick="app.confirmDigitalPayment()">
                                    Konfirmasi Pembayaran
                                </button>
                            </div>

                            <button class="btn-pay" id="btnPay" onclick="app.processPayment()" disabled>
                                Bayar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Detail Modal -->
            <div class="modal-overlay" id="modalOverlay">
                <div class="modal product-detail-modal">
                    <div class="modal-header">
                        <div class="modal-title">Detail Produk</div>
                        <button class="modal-close" onclick="app.closeModal()">&times;</button>
                    </div>
                    <div class="product-info" id="modalProductInfo"></div>
                    <div class="qty-control-modal">
                        <button class="qty-btn-large" onclick="app.adjustModalQty(-1)">-</button>
                        <div class="qty-display-large" id="modalQty">1</div>
                        <button class="qty-btn-large" onclick="app.adjustModalQty(1)">+</button>
                    </div>
                    <button class="btn-add-transaction" onclick="app.addToCartFromModal()">
                        Tambah ke Transaksi
                    </button>
                </div>
            </div>

            <!-- Receipt Modal -->
            <div class="modal-overlay" id="receiptModal">
                <div class="modal">
                    <div class="modal-header">
                        <div class="modal-title">Struk Pembayaran</div>
                        <button class="modal-close" onclick="app.closeReceipt()">&times;</button>
                    </div>
                    <div class="receipt" id="receiptContent"></div>
                    <div style="margin-top: 20px; display: flex; gap: 10px;">
                        <button class="btn-add-transaction" onclick="app.printReceipt()">
                            🖨️ Cetak Struk
                        </button>
                        <button class="btn-new-transaction" onclick="app.closeReceipt(); app.newTransaction();">
                            Transaksi Baru
                        </button>
                    </div>
                </div>
            </div>

            <!-- Toast Notification -->
            <div class="toast" id="toast">
                <span id="toastMessage"></span>
                <button class="toast-undo" id="toastUndo">Undo</button>
            </div>


        </div>

        <!-- JavaScript -->
        <script src="js/kasir.js"></script>
    </main>
</body>

</html>