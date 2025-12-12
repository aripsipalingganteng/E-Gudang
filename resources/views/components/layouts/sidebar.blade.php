<div class="sidebar-menu">
                <a wire:navigate href="/admin/dashboard" class="menu-item active" @click="mobileMenuOpen = false">
                    <i class="fas fa-home"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
                <a wire:navigate href="/admin/user" class="menu-item" @click="mobileMenuOpen = false">
                    <i class="fas fa-box"></i>
                    <span class="menu-text">Data User</span>
                </a>
                <a wire:navigate href="/admin/kategori" class="menu-item" @click="mobileMenuOpen = false">
                    <i class="fas fa-warehouse"></i>
                    <span class="menu-text">Kategori</span>
                </a>
                <a wire:navigate href="/admin/barang" class="menu-item" @click="mobileMenuOpen = false">
                    <i class="fas fa-sign-in-alt"></i>
                    <span class="menu-text">Barang Masuk</span>
                </a>
                
            </div>