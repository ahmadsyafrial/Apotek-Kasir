<?php 
include "php/sidebar.php";
include "php/topbar.php";
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
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Main Content -->
    <main class="main-content">
        
        

        <!-- Content Area -->
        <div class="content-area">
            
            <!-- Dashboard View -->
            <div id="view-dashboard" class="view-section active">
                <div class="page-header">
                    <h2>Dashboard Overview</h2>
                    <p>Selamat datang kembali, berikut ringkasan hari ini</p>
                </div>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon green">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <span class="stat-badge green">+12%</span>
                        </div>
                        <p class="stat-label">Penjualan Hari Ini</p>
                        <h3 class="stat-value">Rp 8.450.000</h3>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon blue">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <span class="stat-badge blue">+5%</span>
                        </div>
                        <p class="stat-label">Total Transaksi</p>
                        <h3 class="stat-value">42</h3>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon amber">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <span class="stat-badge amber">Perlu Perhatian</span>
                        </div>
                        <p class="stat-label">Stok Hampir Habis</p>
                        <h3 class="stat-value">8 Item</h3>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon red">
                                <i class="fas fa-calendar-times"></i>
                            </div>
                            <span class="stat-badge red">Segera</span>
                        </div>
                        <p class="stat-label">Obat Expired</p>
                        <h3 class="stat-value">3 Item</h3>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="charts-grid">
                    <div class="chart-card large">
                        <div class="chart-header">
                            <h3>Grafik Penjualan Bulanan</h3>
                            <select class="select-input">
                                <option>2024</option>
                                <option>2023</option>
                            </select>
                        </div>
                        <canvas id="salesChart" height="300"></canvas>
                    </div>

                    <div class="chart-card">
                        <h3>Metode Pembayaran</h3>
                        <canvas id="paymentChart" height="260"></canvas>
                        <div class="payment-legend">
                            <div class="legend-item">
                                <span class="legend-dot green"></span>
                                <span>Tunai</span>
                                <span class="legend-value">45%</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-dot blue"></span>
                                <span>Transfer</span>
                                <span class="legend-value">30%</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-dot amber"></span>
                                <span>E-Wallet</span>
                                <span class="legend-value">15%</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-dot purple"></span>
                                <span>BPJS</span>
                                <span class="legend-value">10%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="table-card">
                    <div class="table-header">
                        <h3>Transaksi Terbaru</h3>
                        <button class="link-btn">Lihat Semua</button>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID Transaksi</th>
                                    <th>Waktu</th>
                                    <th>Item</th>
                                    <th>Metode</th>
                                    <th class="text-right">Total</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-medium">#TRX-001</td>
                                    <td class="text-muted">14:30</td>
                                    <td>5 Item</td>
                                    <td><span class="badge green">Tunai</span></td>
                                    <td class="text-right font-semibold">Rp 245.000</td>
                                    <td class="text-center"><span class="badge success">Sukses</span></td>
                                </tr>
                                <tr>
                                    <td class="font-medium">#TRX-002</td>
                                    <td class="text-muted">14:15</td>
                                    <td>3 Item</td>
                                    <td><span class="badge blue">Transfer</span></td>
                                    <td class="text-right font-semibold">Rp 180.000</td>
                                    <td class="text-center"><span class="badge success">Sukses</span></td>
                                </tr>
                                <tr>
                                    <td class="font-medium">#TRX-003</td>
                                    <td class="text-muted">13:45</td>
                                    <td>2 Item</td>
                                    <td><span class="badge purple">BPJS</span></td>
                                    <td class="text-right font-semibold">Rp 0</td>
                                    <td class="text-center"><span class="badge success">Sukses</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Data Obat View -->
            <div id="view-obat" class="view-section">
                <div class="page-header flex-between">
                    <div>
                        <h2>Data Obat</h2>
                        <p>Kelola data obat dan produk apotek</p>
                    </div>
                    <button onclick="openModal('modal-tambah-obat')" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Tambah Obat
                    </button>
                </div>

                <div class="table-card">
                    <div class="table-toolbar">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="Cari nama obat, ID, atau kategori...">
                        </div>
                        <div class="toolbar-actions">
                            <select class="select-input">
                                <option>Semua Kategori</option>
                                <option>Obat Bebas</option>
                                <option>Obat Keras</option>
                                <option>Herbal</option>
                            </select>
                            <button class="btn btn-icon"><i class="fas fa-filter"></i></button>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID Obat</th>
                                    <th>Nama Obat</th>
                                    <th>Kategori</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Stok</th>
                                    <th>Expired</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-medium">OBT-001</td>
                                    <td>
                                        <div class="product-info">
                                            <div class="product-icon"><i class="fas fa-pills"></i></div>
                                            <span>Paracetamol 500mg</span>
                                        </div>
                                    </td>
                                    <td><span class="badge blue-light">Obat Bebas</span></td>
                                    <td class="text-muted">Rp 2.500</td>
                                    <td class="font-semibold">Rp 5.000</td>
                                    <td><span class="badge stock-high">150</span></td>
                                    <td class="text-muted">12/2025</td>
                                    <td class="text-center">
                                        <button class="btn-icon text-blue"><i class="fas fa-edit"></i></button>
                                        <button class="btn-icon text-red"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-medium">OBT-002</td>
                                    <td>
                                        <div class="product-info">
                                            <div class="product-icon"><i class="fas fa-pills"></i></div>
                                            <span>Amoxicillin 500mg</span>
                                        </div>
                                    </td>
                                    <td><span class="badge red-light">Obat Keras</span></td>
                                    <td class="text-muted">Rp 8.000</td>
                                    <td class="font-semibold">Rp 15.000</td>
                                    <td><span class="badge stock-low">12</span></td>
                                    <td class="text-muted">06/2024</td>
                                    <td class="text-center">
                                        <button class="btn-icon text-blue"><i class="fas fa-edit"></i></button>
                                        <button class="btn-icon text-red"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="table-footer">
                        <p class="text-muted">Menampilkan 1-10 dari 45 data</p>
                        <div class="pagination">
                            <button class="btn btn-sm">Previous</button>
                            <button class="btn btn-sm active">1</button>
                            <button class="btn btn-sm">2</button>
                            <button class="btn btn-sm">Next</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaksi/Kasir View -->
            <div id="view-transaksi" class="view-section">
                <div class="pos-layout">
                    <!-- Product Grid -->
                    <div class="pos-products">
                        <div class="search-card">
                            <div class="search-box large">
                                <i class="fas fa-search"></i>
                                <input type="text" id="search-product" placeholder="Cari obat (scan barcode atau ketik nama)..." onkeyup="filterProducts(this.value)">
                            </div>
                            <div class="category-filter">
                                <button class="btn-filter active">Semua</button>
                                <button class="btn-filter">Obat Bebas</button>
                                <button class="btn-filter">Obat Keras</button>
                                <button class="btn-filter">Vitamin</button>
                                <button class="btn-filter">Herbal</button>
                            </div>
                        </div>

                        <div class="product-grid" id="product-grid">
                            <!-- Products rendered by JS -->
                        </div>
                    </div>

                    <!-- Cart Section -->
                    <div class="pos-cart">
                        <div class="cart-header">
                            <h3><i class="fas fa-shopping-cart"></i> Keranjang</h3>
                        </div>
                        
                        <div class="cart-items" id="cart-items">
                            <div class="empty-cart">
                                <i class="fas fa-cart-plus"></i>
                                <p>Keranjang kosong</p>
                            </div>
                        </div>

                        <div class="cart-footer">
                            <div class="cart-summary">
                                <div class="summary-row">
                                    <span>Subtotal</span>
                                    <span id="subtotal">Rp 0</span>
                                </div>
                                <div class="summary-row">
                                    <span>Diskon</span>
                                    <span>Rp 0</span>
                                </div>
                                <div class="summary-row total">
                                    <span>Total</span>
                                    <span id="total">Rp 0</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Metode Pembayaran</label>
                                <select id="payment-method" class="select-input full">
                                    <option value="cash">Tunai</option>
                                    <option value="transfer">Transfer Bank</option>
                                    <option value="ewallet">E-Wallet</option>
                                    <option value="bpjs">Member / BPJS</option>
                                </select>
                            </div>

                            <div id="member-select" class="form-group hidden">
                                <label>Pilih Member</label>
                                <select class="select-input full">
                                    <option>Ahmad Fauzi - BPJS</option>
                                    <option>Siti Aminah - Member</option>
                                    <option>Budi Santoso - BPJS</option>
                                </select>
                            </div>

                            <button onclick="processTransaction()" class="btn btn-primary btn-large btn-full">
                                <i class="fas fa-check-circle"></i>
                                Bayar & Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kategori View -->
            <div id="view-kategori" class="view-section">
                <div class="page-header flex-between">
                    <div>
                        <h2>Kategori Obat</h2>
                        <p>Kelola kategori produk</p>
                    </div>
                    <button class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Kategori
                    </button>
                </div>
                <div class="category-grid">
                    <div class="category-card">
                        <div class="category-icon blue"><i class="fas fa-pills"></i></div>
                        <h3>Obat Bebas</h3>
                        <p>24 Produk</p>
                    </div>
                    <div class="category-card">
                        <div class="category-icon red"><i class="fas fa-prescription-bottle-alt"></i></div>
                        <h3>Obat Keras</h3>
                        <p>18 Produk</p>
                    </div>
                    <div class="category-card">
                        <div class="category-icon green"><i class="fas fa-leaf"></i></div>
                        <h3>Herbal</h3>
                        <p>12 Produk</p>
                    </div>
                </div>
            </div>

            <!-- Supplier View -->
            <div id="view-supplier" class="view-section">
                <div class="page-header flex-between">
                    <h2>Data Supplier</h2>
                    <button class="btn btn-primary">Tambah Supplier</button>
                </div>
                <div class="table-card">
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Nama Supplier</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-medium">PT. Kimia Farma</td>
                                    <td class="text-muted">Jl. Sudirman No. 123, Jakarta</td>
                                    <td class="text-muted">021-5551234</td>
                                    <td class="text-center">
                                        <button class="btn-icon text-blue"><i class="fas fa-edit"></i></button>
                                        <button class="btn-icon text-red"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-medium">PT. Indofarma</td>
                                    <td class="text-muted">Jl. Thamrin No. 45, Bandung</td>
                                    <td class="text-muted">022-5555678</td>
                                    <td class="text-center">
                                        <button class="btn-icon text-blue"><i class="fas fa-edit"></i></button>
                                        <button class="btn-icon text-red"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Stok View -->
            <div id="view-stok" class="view-section">
                <div class="page-header">
                    <h2>Manajemen Stok</h2>
                    <p>Monitor stok masuk, keluar, dan notifikasi</p>
                </div>
                <div class="form-grid">
                    <div class="form-card">
                        <h3><i class="fas fa-arrow-down text-green"></i> Stok Masuk</h3>
                        <form>
                            <div class="form-group">
                                <input type="text" placeholder="ID Obat" class="form-input">
                            </div>
                            <div class="form-group">
                                <input type="number" placeholder="Jumlah" class="form-input">
                            </div>
                            <button class="btn btn-success btn-full">Tambah Stok</button>
                        </form>
                    </div>
                    <div class="form-card">
                        <h3><i class="fas fa-arrow-up text-red"></i> Stok Keluar</h3>
                        <form>
                            <div class="form-group">
                                <input type="text" placeholder="ID Obat" class="form-input">
                            </div>
                            <div class="form-group">
                                <input type="number" placeholder="Jumlah" class="form-input">
                            </div>
                            <button class="btn btn-danger btn-full">Kurangi Stok</button>
                        </form>
                    </div>
                </div>
                
                <div class="alert-box warning">
                    <h3><i class="fas fa-exclamation-triangle"></i> Peringatan Stok</h3>
                    <div class="alert-list">
                        <div class="alert-item">
                            <span>Amoxicillin 500mg</span>
                            <span class="alert-badge">Sisa 12 pcs</span>
                        </div>
                        <div class="alert-item">
                            <span>Vitamin C 1000mg</span>
                            <span class="alert-badge">Sisa 8 pcs</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Member View -->
            <div id="view-member" class="view-section">
                <div class="page-header flex-between">
                    <h2>Member / BPJS</h2>
                    <button class="btn btn-primary">Tambah Member</button>
                </div>
                <div class="table-card">
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>No. Member/BPJS</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Tipe</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-medium">Ahmad Fauzi</td>
                                    <td class="text-muted">0001234567890</td>
                                    <td class="text-muted">Jl. Mawar No. 12</td>
                                    <td class="text-muted">08123456789</td>
                                    <td><span class="badge purple">BPJS</span></td>
                                    <td class="text-center">
                                        <button class="btn-icon text-blue"><i class="fas fa-edit"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-medium">Siti Aminah</td>
                                    <td class="text-muted">MBR-001</td>
                                    <td class="text-muted">Jl. Melati No. 5</td>
                                    <td class="text-muted">08234567890</td>
                                    <td><span class="badge blue-light">Member</span></td>
                                    <td class="text-center">
                                        <button class="btn-icon text-blue"><i class="fas fa-edit"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Laporan View -->
            <div id="view-laporan" class="view-section">
                <div class="page-header">
                    <h2>Laporan</h2>
                    <p>Generate dan unduh laporan sistem</p>
                </div>
                <div class="report-grid">
                    <button class="report-card">
                        <div class="report-icon green"><i class="fas fa-file-invoice-dollar"></i></div>
                        <h3>Penjualan Harian</h3>
                        <p>Laporan transaksi hari ini</p>
                    </button>
                    
                    <button class="report-card">
                        <div class="report-icon blue"><i class="fas fa-calendar-alt"></i></div>
                        <h3>Penjualan Bulanan</h3>
                        <p>Rekap penjualan bulan ini</p>
                    </button>

                    <button class="report-card">
                        <div class="report-icon amber"><i class="fas fa-box"></i></div>
                        <h3>Stok Obat</h3>
                        <p>Laporan inventori saat ini</p>
                    </button>

                    <button class="report-card">
                        <div class="report-icon red"><i class="fas fa-calendar-times"></i></div>
                        <h3>Obat Expired</h3>
                        <p>Daftar obat mendekati kadaluarsa</p>
                    </button>

                    <button class="report-card">
                        <div class="report-icon purple"><i class="fas fa-user-md"></i></div>
                        <h3>Transaksi per Kasir</h3>
                        <p>Performa kasir individual</p>
                    </button>

                    <button class="report-card">
                        <div class="report-icon teal"><i class="fas fa-credit-card"></i></div>
                        <h3>Metode Pembayaran</h3>
                        <p>Statistik pembayaran</p>
                    </button>
                </div>
            </div>

            <!-- Pengguna View -->
            <div id="view-pengguna" class="view-section">
                <div class="page-header flex-between">
                    <h2>Manajemen Pengguna</h2>
                    <button class="btn btn-primary">Tambah Pengguna</button>
                </div>
                <div class="table-card">
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="user-info-cell">
                                            <div class="avatar small green">A</div>
                                            <span>Administrator</span>
                                        </div>
                                    </td>
                                    <td class="text-muted">admin</td>
                                    <td><span class="badge red-light">Admin</span></td>
                                    <td class="text-center"><span class="badge success">Aktif</span></td>
                                    <td class="text-center">
                                        <button class="btn-icon text-blue"><i class="fas fa-edit"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="user-info-cell">
                                            <div class="avatar small blue">K</div>
                                            <span>Kasir 1</span>
                                        </div>
                                    </td>
                                    <td class="text-muted">kasir1</td>
                                    <td><span class="badge blue-light">Kasir</span></td>
                                    <td class="text-center"><span class="badge success">Aktif</span></td>
                                    <td class="text-center">
                                        <button class="btn-icon text-blue"><i class="fas fa-edit"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Modal Tambah Obat -->
    <div id="modal-tambah-obat" class="modal">
        <div class="modal-overlay" onclick="closeModal('modal-tambah-obat')"></div>
        <div class="modal-content">
            <div class="modal-header">
                <h3>Tambah Obat Baru</h3>
                <button onclick="closeModal('modal-tambah-obat')" class="btn-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form onsubmit="saveObat(event)">
                <div class="form-row">
                    <div class="form-group">
                        <label>ID Obat</label>
                        <input type="text" class="form-input" placeholder="OBT-00X">
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select class="form-input">
                            <option>Obat Bebas</option>
                            <option>Obat Keras</option>
                            <option>Herbal</option>
                            <option>Vitamin</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Nama Obat</label>
                    <input type="text" class="form-input" placeholder="Nama obat">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Harga Beli</label>
                        <input type="number" class="form-input" placeholder="0">
                    </div>
                    <div class="form-group">
                        <label>Harga Jual</label>
                        <input type="number" class="form-input" placeholder="0">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Stok Awal</label>
                        <input type="number" class="form-input" placeholder="0">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Expired</label>
                        <input type="month" class="form-input">
                    </div>
                </div>
                <div class="form-group">
                    <label>Supplier</label>
                    <select class="form-input">
                        <option>PT. Kimia Farma</option>
                        <option>PT. Indofarma</option>
                        <option>PT. Kalbe Farma</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('modal-tambah-obat')" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="js/main.js"></script>
</body>
</html>