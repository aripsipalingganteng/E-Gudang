@php
use Illuminate\Support\Facades\Auth;
@endphp
<div class="topbar">
    <div class="topbar-left">
        <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
            <i class="fas fa-bars"></i>
        </button>
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Cari barang, kategori, atau user...">
        </div>
    </div>
    
    <div class="topbar-right">
        <!-- Notifications -->
        <div class="notification-icon">
            <i class="fas fa-bell"></i>
            <span class="notification-badge">3</span>
        </div>

        <!-- User Profile -->
        <div class="user-profile">
            <button class="user-profile-btn" onclick="toggleUserPopup()">
                <div class="user-avatar">
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4f46e5&color=fff'">
                </div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">{{ Auth::user()->role ?? 'User' }}</div>
                </div>
                <i class="fas fa-chevron-down" id="chevron-icon"></i>
            </button>

            <!-- User Popup -->
            <div class="user-popup" id="userPopup">
                <!-- User Info -->
                <div class="popup-header">
                    <div class="popup-user-avatar">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4f46e5&color=fff'">
                    </div>
                    <div class="popup-user-details">
                        <h4>{{ Auth::user()->name }}</h4>
                        <p>{{ Auth::user()->email }}</p>
                        <span class="role-badge">{{ Auth::user()->role ?? 'User' }}</span>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="popup-stats">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value" id="totalUsers">{{ \App\Models\User::count() }}</div>
                            <div class="stat-label">Total Users</div>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value" id="totalBarang">{{ \App\Models\Barang::count() }}</div>
                            <div class="stat-label">Total Barang</div>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value" id="totalKategori">{{ \App\Models\Kategori::count() }}</div>
                            <div class="stat-label">Kategori</div>
                        </div>
                    </div>
                </div>


                <!-- Recent Activity -->
                <div class="popup-section">
                    <div class="section-header">
                        <h5>Recent Activity</h5>
                        <a href="#" class="view-all">View All</a>
                    </div>
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-icon success">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="activity-details">
                                <span>Menambah barang baru</span>
                                <small>5 menit lalu</small>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon warning">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div class="activity-details">
                                <span>Mengupdate kategori</span>
                                <small>1 jam lalu</small>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon info">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="activity-details">
                                <span>User baru terdaftar</span>
                                <small>2 jam lalu</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="popup-footer">
                    <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i>
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// State management
let userPopupOpen = false;

// DOM Elements
const userPopup = document.getElementById('userPopup');
const chevronIcon = document.getElementById('chevronIcon');

// Toggle user popup
function toggleUserPopup() {
    userPopupOpen = !userPopupOpen;
    
    if (userPopupOpen) {
        userPopup.classList.add('active');
        chevronIcon.style.transform = 'rotate(180deg)';
    } else {
        userPopup.classList.remove('active');
        chevronIcon.style.transform = 'rotate(0deg)';
    }
}

// Close popup when clicking outside
document.addEventListener('click', function(event) {
    const userProfile = document.querySelector('.user-profile');
    const userProfileBtn = document.querySelector('.user-profile-btn');
    
    if (userPopupOpen && 
        !userProfile.contains(event.target) && 
        !userProfileBtn.contains(event.target)) {
        closeUserPopup();
    }
});

// Close user popup
function closeUserPopup() {
    userPopupOpen = false;
    userPopup.classList.remove('active');
    chevronIcon.style.transform = 'rotate(0deg)';
}

// Mobile menu toggle
function toggleMobileMenu() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('active');
}

// Close popup on escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && userPopupOpen) {
        closeUserPopup();
    }
});

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    userPopup.classList.remove('active');
});
</script>

<style>
:root {
    --primary: #4f46e5;
    --primary-dark: #4338ca;
    --secondary: #64748b;
    --success: #10b981;
    --warning: #f59e0b;
    --error: #ef4444;
    --gray-50: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-300: #cbd5e1;
    --gray-400: #94a3b8;
    --gray-500: #64748b;
    --gray-600: #475569;
    --gray-700: #334155;
    --gray-800: #1e293b;
    --gray-900: #0f172a;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --radius: 8px;
    --radius-lg: 12px;
}

.topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 24px;
    background: white;
    border-bottom: 1px solid var(--gray-200);
    box-shadow: var(--shadow-sm);
    position: sticky;
    top: 0;
    z-index: 100;
    backdrop-filter: blur(8px);
}

.topbar-left {
    display: flex;
    align-items: center;
    gap: 20px;
    flex: 1;
}

.mobile-menu-btn {
    display: none;
    background: none;
    border: none;
    font-size: 18px;
    color: var(--gray-600);
    cursor: pointer;
    padding: 8px;
    border-radius: var(--radius);
    transition: all 0.2s ease;
}

.mobile-menu-btn:hover {
    background: var(--gray-100);
    color: var(--gray-800);
}

.search-bar {
    position: relative;
    max-width: 400px;
    width: 100%;
}

.search-bar i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-400);
    font-size: 14px;
}

.search-bar input {
    width: 100%;
    padding: 10px 16px 10px 40px;
    border: 1px solid var(--gray-300);
    border-radius: var(--radius);
    font-size: 14px;
    background: var(--gray-50);
    transition: all 0.2s ease;
}

.search-bar input:focus {
    outline: none;
    border-color: var(--primary);
    background: white;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.search-bar input::placeholder {
    color: var(--gray-400);
}

.topbar-right {
    display: flex;
    align-items: center;
    gap: 16px;
}

.notification-icon {
    position: relative;
    padding: 8px;
    border-radius: var(--radius);
    color: var(--gray-600);
    cursor: pointer;
    transition: all 0.2s ease;
}

.notification-icon:hover {
    background: var(--gray-100);
    color: var(--gray-800);
}

.notification-badge {
    position: absolute;
    top: 4px;
    right: 4px;
    background: var(--error);
    color: white;
    font-size: 10px;
    padding: 2px 5px;
    border-radius: 10px;
    min-width: 16px;
    text-align: center;
    font-weight: 600;
}

.user-profile {
    position: relative;
}

.user-profile-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    background: none;
    border: none;
    padding: 6px 12px;
    border-radius: var(--radius);
    cursor: pointer;
    transition: all 0.2s ease;
}

.user-profile-btn:hover {
    background: var(--gray-100);
}

.user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    overflow: hidden;
}

.user-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.user-info {
    text-align: left;
}

.user-name {
    font-weight: 600;
    font-size: 14px;
    color: var(--gray-800);
    line-height: 1.2;
}

.user-role {
    font-size: 12px;
    color: var(--gray-500);
    line-height: 1.2;
}

#chevron-icon {
    transition: transform 0.3s ease;
    color: var(--gray-400);
    font-size: 12px;
}

/* User Popup Styles */
.user-popup {
    position: absolute;
    top: 100%;
    right: 0;
    width: 380px;
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--gray-200);
    margin-top: 8px;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.2s ease;
}

.user-popup.active {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.popup-header {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 24px;
    background: linear-gradient(135deg, var(--gray-50), var(--gray-100));
    border-bottom: 1px solid var(--gray-200);
}

.popup-user-avatar {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid white;
    box-shadow: var(--shadow);
}

.popup-user-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.popup-user-details h4 {
    margin: 0 0 4px 0;
    font-size: 16px;
    font-weight: 600;
    color: var(--gray-900);
}

.popup-user-details p {
    margin: 0 0 8px 0;
    color: var(--gray-600);
    font-size: 14px;
}

.role-badge {
    background: var(--primary);
    color: white;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.popup-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1px;
    background: var(--gray-100);
    margin: 0;
}

.stat-item {
    background: white;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: background-color 0.2s ease;
}

.stat-item:hover {
    background: var(--gray-50);
}

.stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: var(--primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

.stat-content {
    flex: 1;
}

.stat-value {
    font-size: 20px;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 2px;
    line-height: 1;
}

.stat-label {
    font-size: 12px;
    color: var(--gray-500);
    font-weight: 500;
}

.popup-section {
    padding: 20px 24px;
    border-bottom: 1px solid var(--gray-100);
}

.popup-section:last-of-type {
    border-bottom: none;
}

.popup-section h5 {
    margin: 0 0 16px 0;
    font-size: 14px;
    font-weight: 600;
    color: var(--gray-700);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.view-all {
    font-size: 12px;
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
}

.view-all:hover {
    text-decoration: underline;
}

.action-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 8px;
}

.action-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 16px;
    background: var(--gray-50);
    border: 1px solid var(--gray-200);
    border-radius: var(--radius);
    color: var(--gray-700);
    text-decoration: none;
    transition: all 0.2s ease;
    text-align: center;
}

.action-item:hover {
    background: white;
    border-color: var(--primary);
    color: var(--primary);
    transform: translateY(-2px);
    box-shadow: var(--shadow);
}

.action-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: var(--primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

.action-item span {
    font-size: 12px;
    font-weight: 500;
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: var(--gray-50);
    border-radius: var(--radius);
    transition: background-color 0.2s ease;
}

.activity-item:hover {
    background: var(--gray-100);
}

.activity-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
}

.activity-icon.success {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
}

.activity-icon.warning {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
}

.activity-icon.info {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}

.activity-details {
    flex: 1;
}

.activity-details span {
    display: block;
    font-size: 14px;
    color: var(--gray-800);
    margin-bottom: 2px;
    font-weight: 500;
}

.activity-details small {
    font-size: 12px;
    color: var(--gray-500);
}

.popup-footer {
    padding: 16px 24px;
    background: var(--gray-50);
    border-top: 1px solid var(--gray-200);
}

.logout-form {
    width: 100%;
}

.logout-btn {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 16px;
    background: white;
    border: 1px solid var(--gray-300);
    border-radius: var(--radius);
    color: var(--gray-700);
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.logout-btn:hover {
    background: var(--error);
    border-color: var(--error);
    color: white;
    transform: translateY(-1px);
    box-shadow: var(--shadow);
}

/* Responsive Design */
@media (max-width: 768px) {
    .topbar {
        padding: 12px 16px;
    }
    
    .mobile-menu-btn {
        display: block;
    }
    
    .search-bar {
        max-width: 200px;
    }
    
    .user-info {
        display: none;
    }
    
    .user-popup {
        width: 320px;
        right: -10px;
    }
    
    .popup-header {
        flex-direction: column;
        text-align: center;
        padding: 20px;
    }
    
    .action-grid {
        grid-template-columns: 1fr;
    }
    
    .popup-stats {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .topbar-left {
        gap: 12px;
    }
    
    .search-bar {
        max-width: 150px;
    }
    
    .user-popup {
        width: 280px;
        right: -20px;
    }
    
    .notification-icon {
        display: none;
    }
}

/* Animation for mobile menu */
.sidebar.active {
    transform: translateX(0);
}

/* Smooth transitions */
* {
    transition: color 0.2s ease, background-color 0.2s ease, border-color 0.2s ease;
}
</style>