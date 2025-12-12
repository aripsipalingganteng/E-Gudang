<div>
    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="content">
        <div class="page-header">
            <h1 class="page-title">Manajemen User</h1>
            <p class="page-subtitle">Kelola data user dengan mudah dan efisien</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ \App\Models\User::count() }}</h3>
                    <p>Total User</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ \App\Models\User::where('role', 'admin')->count() }}</h3>
                    <p>Admin</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ \App\Models\User::where('role', 'user')->count() }}</h3>
                    <p>User Biasa</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ \App\Models\User::whereDate('created_at', today())->count() }}</h3>
                    <p>User Baru Hari Ini</p>
                </div>
            </div>
        </div>
        
        <!-- Users Table -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Daftar User</h2>
                <div class="card-actions">
                    <div class="search-box">
                        <input type="text" wire:model.live="search" placeholder="Cari user..." class="form-control">
                        <i class="fas fa-search"></i>
                    </div>
                    <button class="btn btn-primary" wire:click="create">
                        <i class="fas fa-plus"></i> Tambah User
                    </button>
                </div>
            </div>

            <!-- Update bagian Card Actions -->
<div class="card-actions">
    <div class="search-box">
        <input type="text" wire:model.live="search" placeholder="Cari user..." class="form-control">
        <i class="fas fa-search"></i>
    </div>
    
    <!-- Filter Section -->
    <div class="filter-section" style="display: flex; gap: 10px; align-items: center;">
        <select wire:model="selectedRole" class="form-control" style="width: auto;">
            <option value="all">Semua Role</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
        
        <input type="date" wire:model="startDate" class="form-control" placeholder="Dari Tanggal">
        <input type="date" wire:model="endDate" class="form-control" placeholder="Sampai Tanggal">
        
        @if($search || $selectedRole !== 'all' || $startDate || $endDate)
        <button wire:click="resetFilters" class="btn btn-secondary">
            <i class="fas fa-times"></i> Reset
        </button>
        @endif
    </div>
    
    <!-- Export Buttons -->
    <div class="export-buttons" style="display: flex; gap: 10px;">
        <button class="btn btn-success" wire:click="exportExcel">
            <i class="fas fa-file-excel"></i> Export Excel
        </button>
        <button class="btn btn-danger" wire:click="exportPDF">
            <i class="fas fa-file-pdf"></i> Export PDF
        </button>
    </div>
    
    <button class="btn btn-primary" wire:click="create">
        <i class="fas fa-plus"></i> Tambah User
    </button>
</div>      

            <style>
                .filter-section {
    background: #f8f9fa;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
}

.filter-section .form-control {
    min-width: 150px;
}

.export-buttons {
    margin-left: auto;
}

.export-buttons .btn {
    display: flex;
    align-items: center;
    gap: 5px;
}

@media (max-width: 768px) {
    .filter-section {
        flex-wrap: wrap;
    }
    
    .filter-section .form-control {
        width: 100%;
        margin-bottom: 10px;
    }
    
    .export-buttons {
        flex-wrap: wrap;
    }
}
            </style>
            
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Tanggal Dibuat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="user-info">
                                    @if($user->profile_photo_path)
                                        <img src="{{ Storage::url($user->profile_photo_path) }}" alt="{{ $user->name }}" class="user-avatar">
                                    @else
                                        <div class="user-avatar placeholder">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <span>{{ $user->name }}</span>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="role-badge role-{{ $user->role }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <span class="status status-in">Aktif</span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit" wire:click="edit({{ $user->id }})" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn delete" wire:click="confirmDelete({{ $user->id }})" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data user</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- User Modal -->
    @if($showModal)
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: flex; align-items: center; justify-content: center;">
        <div style="background: white; padding: 20px; border-radius: 8px; width: 90%; max-width: 500px; max-height: 90vh; overflow-y: auto;">
            <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 20px;">
                <h3 style="margin: 0;">{{ $editMode ? 'Edit User' : 'Tambah User Baru' }}</h3>
                <button type="button" wire:click="closeModal" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
            </div>
            
            <form wire:submit.prevent="store">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Nama</label>
                    <input type="text" wire:model="name" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    @error('name') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Email</label>
                    <input type="email" wire:model="email" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    @error('email') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                        {{ $editMode ? 'Password (Kosongkan jika tidak diubah)' : 'Password' }}
                    </label>
                    <input type="password" wire:model="password" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    @error('password') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Role</label>
                    <select wire:model="role" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                    @error('role') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Foto Profil</label>
                    <input type="file" wire:model="profile_photo" accept="image/*" style="width: 100%; padding: 8px;">
                    @error('profile_photo') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
                    
                    @if ($profile_photo)
                        <div style="margin-top: 10px;">
                            <img src="{{ $profile_photo->temporaryUrl() }}" style="max-width: 100px; max-height: 100px; border-radius: 8px;" alt="Preview">
                        </div>
                    @endif
                </div>
                
                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" wire:click="closeModal" style="padding: 8px 16px; border: 1px solid #ddd; border-radius: 4px; background: white; cursor: pointer;">Batal</button>
                    <button type="submit" style="padding: 8px 16px; border: none; border-radius: 4px; background: #4f46e5; color: white; cursor: pointer;">
                        {{ $editMode ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($confirmingDelete)
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: flex; align-items: center; justify-content: center;">
        <div style="background: white; padding: 20px; border-radius: 8px; width: 90%; max-width: 400px;">
            <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 20px;">
                <h3 style="margin: 0;">Konfirmasi Hapus</h3>
                <button type="button" wire:click="closeModal" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
            </div>
            
            <p style="margin-bottom: 20px;">Apakah Anda yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.</p>
            
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" wire:click="closeModal" style="padding: 8px 16px; border: 1px solid #ddd; border-radius: 4px; background: white; cursor: pointer;">Batal</button>
                <button type="button" wire:click="destroy" style="padding: 8px 16px; border: none; border-radius: 4px; background: #dc2626; color: white; cursor: pointer;">Hapus</button>
            </div>
        </div>
    </div>
    @endif
    <style>
    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .user-avatar.placeholder {
        background: #4f46e5;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        width: 32px;
        height: 32px;
        border-radius: 50%;
    }
    
    .role-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .role-admin {
        background: #fee2e2;
        color: #dc2626;
    }
    
    .role-user {
        background: #dbeafe;
        color: #1d4ed8;
    }
    
    .search-box {
        position: relative;
        width: 250px;
    }
    
    .search-box input {
        padding-left: 35px;
    }
    
    .search-box .fa-search {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
    }
    
    .action-buttons {
        display: flex;
        gap: 5px;
    }
    
    .action-btn {
        border: none;
        padding: 5px 8px;
        border-radius: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .action-btn.edit {
        background: #dbeafe;
        color: #1d4ed8;
    }
    
    .action-btn.delete {
        background: #fee2e2;
        color: #dc2626;
    }
    
    .status {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .status-in {
        background: #d1fae5;
        color: #065f46;
    }
</style>
</div>

