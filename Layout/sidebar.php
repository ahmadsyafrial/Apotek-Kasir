    <aside id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon">
                <i class="fas fa-mortar-pestle"></i>
            </div>
            <div class="logo-text">
                <h1>HealPlus+</h1>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-label">Menu Utama</div>

            <button onclick="switchTab('dashboard')" class="nav-item">
                <a href="index.php" class="nav-item-link">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </button>

            <button onclick="switchTab('obat')" class="nav-item">
                <a href="obat.php" class="nav-item-link">
                    <i class="fas fa-pills"></i>
                    <span>Data Obat</span>
                </a>
            </button>

            <button onclick="switchTab('kategori')" class="nav-item">
                <a href="kategori.php" class="nav-item-link">
                    <i class="fas fa-tags"></i>
                    <span>Kategori Obat</span>
                </a>
            </button>

            <button onclick="switchTab('supplier')" class="nav-item">
                <a href="supplier.php" class="nav-item-link">
                    <i class="fas fa-truck"></i>
                    <span>Supplier</span>
                </a>
            </button>

            <button onclick="switchTab('stok')" class="nav-item">
                <a href="stok.php" class="nav-item-link">
                    <i class="fas fa-boxes"></i>
                    <span>Stok Obat</span>
                </a>
            </button>

            <button onclick="switchTab('transaksi')" class="nav-item">
                <a href="kasir.php" class="nav-item-link">
                    <i class="fas fa-cash-register"></i>
                    <span>Transaksi</span>
                </a>
            </button>

            <button onclick="switchTab('member')" class="nav-item">
                <a href="member.php" class="nav-item-link">
                    <i class="fas fa-id-card"></i>
                    <span>Member / BPJS</span>
                </a>
            </button>

            <button onclick="switchTab('laporan')" class="nav-item">
                <a href="laporan.php" class="nav-item-link">
                    <i class="fas fa-chart-bar"></i>
                    <span>Laporan</span>
                </a>
            </button>

            <button onclick="switchTab('pengguna')" class="nav-item">
                <a href="pengguna.php" class="nav-item-link">
                    <i class="fas fa-users-cog"></i>
                    <span>Pengguna</span>
                </a>
            </button>

            <div class="nav-divider"></div>

            <button onclick="logout()" class="nav-item logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Keluar</span>
            </button>
        </nav>
    </aside>