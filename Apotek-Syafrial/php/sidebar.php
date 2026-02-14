    <aside id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon">
                <i class="fas fa-mortar-pestle"></i>
            </div>
            <div class="logo-text">
                <h1>Apotek Sehat</h1>
                <p>Sistem Kasir</p>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-label">Menu Utama</div>
            
            <button onclick="switchTab('dashboard')" class="nav-item active">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </button>

            <button onclick="switchTab('obat')" class="nav-item">
                <i class="fas fa-pills"></i>
                <span>Data Obat</span>
            </button>

            <button onclick="switchTab('kategori')" class="nav-item">
                <i class="fas fa-tags"></i>
                <span>Kategori Obat</span>
            </button>

            <button onclick="switchTab('supplier')" class="nav-item">
                <i class="fas fa-truck"></i>
                <span>Supplier</span>
            </button>

            <button onclick="switchTab('stok')" class="nav-item">
                <i class="fas fa-boxes"></i>
                <span>Stok Obat</span>
            </button>

            <button onclick="switchTab('transaksi')" class="nav-item">
                <i class="fas fa-cash-register"></i>
                <span>Transaksi</span>
            </button>

            <button onclick="switchTab('member')" class="nav-item">
                <i class="fas fa-id-card"></i>
                <span>Member / BPJS</span>
            </button>

            <button onclick="switchTab('laporan')" class="nav-item">
                <i class="fas fa-chart-bar"></i>
                <span>Laporan</span>
            </button>

            <button onclick="switchTab('pengguna')" class="nav-item">
                <i class="fas fa-users-cog"></i>
                <span>Pengguna</span>
            </button>

            <div class="nav-divider"></div>
            
            <button onclick="logout()" class="nav-item logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Keluar</span>
            </button>
        </nav>
    </aside>