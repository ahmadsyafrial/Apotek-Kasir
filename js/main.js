/**
 * APOTEK SEHAT - MAIN JAVASCRIPT
 * Pharmacy POS Dashboard Application
 */

// ============================================
// DATA STORE
// ============================================

const products = [
    { id: 'OBT-001', name: 'Paracetamol 500mg', price: 5000, stock: 150, category: 'Obat Bebas', image: '💊' },
    { id: 'OBT-002', name: 'Amoxicillin 500mg', price: 15000, stock: 12, category: 'Obat Keras', image: '💉' },
    { id: 'OBT-003', name: 'Vitamin C 1000mg', price: 25000, stock: 45, category: 'Vitamin', image: '🍊' },
    { id: 'OBT-004', name: 'Antasida Doen', price: 8000, stock: 78, category: 'Obat Bebas', image: '🧪' },
    { id: 'OBT-005', name: 'Ibuprofen 400mg', price: 12000, stock: 34, category: 'Obat Bebas', image: '💊' },
    { id: 'OBT-006', name: 'Omeprazole 20mg', price: 18000, stock: 23, category: 'Obat Keras', image: '💊' },
    { id: 'OBT-007', name: 'Betadine', price: 15000, stock: 56, category: 'Obat Luar', image: '🧴' },
    { id: 'OBT-008', name: 'Minyak Kayu Putih', price: 20000, stock: 89, category: 'Herbal', image: '🌿' },
];

let cart = [];
let currentTab = 'dashboard';

// ============================================
// INITIALIZATION
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    renderProducts();
    initCharts();
    setupEventListeners();
    
    // Check URL hash for direct navigation
    const hash = window.location.hash.replace('#', '');
    if (hash && document.getElementById('view-' + hash)) {
        switchTab(hash);
    }
});

// ============================================
// EVENT LISTENERS SETUP
// ============================================

function setupEventListeners() {
    // Payment method change handler
    const paymentMethod = document.getElementById('payment-method');
    if (paymentMethod) {
        paymentMethod.addEventListener('change', handlePaymentMethodChange);
    }
    
    // Close modal when clicking outside
    window.addEventListener('click', handle)}