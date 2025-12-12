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

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="content">
        <div class="page-header">
            <h1 class="page-title">Manajemen Kategori</h1>
            <p class="page-subtitle">Kelola data kategori barang dengan mudah dan efisien</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ \App\Models\Kategori::count() }}</h3>
                    <p>Total Kategori</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ \App\Models\Kategori::has('barangs')->count() }}</h3>
                    <p>Kategori Aktif</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-cube"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ \App\Models\Kategori::doesntHave('barangs')->count() }}</h3>
                    <p>Kategori Kosong</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ \App\Models\Kategori::whereDate('created_at', today())->count() }}</h3>
                    <p>Baru Hari Ini</p>
                </div>
            </div>
        </div>
        
        <!-- Kategoris Table -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Daftar Kategori</h2>
                <div class="card-actions">
                    <div class="search-box">
                        <input type="text" wire:model.live="search" placeholder="Cari kategori..." class="form-control">
                        <i class="fas fa-search"></i>
                    </div>
                    <button class="btn btn-primary" wire:click="create" wire:loading.attr="disabled">
                        <i class="fas fa-plus"></i> 
                        <span wire:loading.remove>Tambah Kategori</span>
                        <span wire:loading>Loading...</span>
                    </button>
                </div>
            </div>
            
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th>Tanggal Dibuat</th>
                            <th>Jumlah Barang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $kategori)
                        <tr>
                            <td>{{ $loop->iteration + ($kategoris->currentPage() - 1) * $kategoris->perPage() }}</td>
                            <td>
                                <div class="kategori-info">
                                    <div class="kategori-icon">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                    <span>{{ $kategori->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="deskripsi-text">{{ Str::limit($kategori->deskripsi, 50) }}</span>
                            </td>
                            <td>{{ $kategori->created_at->format('d M Y') }}</td>
                            <td>
                                <span class="item-count">{{ $kategori->barangs_count ?? 0 }}</span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit" wire:click="edit({{ $kategori->id }})" wire:loading.attr="disabled" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn delete" wire:click="confirmDelete({{ $kategori->id }})" wire:loading.attr="disabled" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data kategori</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer">
                {{ $kategoris->links() }}
            </div>
        </div>
    </div>

    <!-- Kategori Modal -->
    @if($showModal)
    <div class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3>{{ $editMode ? 'Edit Kategori' : 'Tambah Kategori Baru' }}</h3>
                <button type="button" class="close-btn" wire:click="closeModal">&times;</button>
            </div>
            
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Kategori *</label>
                    <input type="text" wire:model="name" class="form-control" placeholder="Masukkan nama kategori">
                    @error('name') <span class="error-text">{{ $message }}</span> @enderror
                </div>
                
                <div class="form-group">
                    <label>Deskripsi *</label>
                    <textarea wire:model="deskripsi" class="form-control" rows="4" placeholder="Masukkan deskripsi kategori"></textarea>
                    @error('deskripsi') <span class="error-text">{{ $message }}</span> @enderror
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModal">Batal</button>
                <button type="button" class="btn btn-primary" wire:click="save" wire:loading.attr="disabled">
                    <span wire:loading.remove>{{ $editMode ? 'Update' : 'Simpan' }}</span>
                    <span wire:loading>Loading...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
    <div class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Konfirmasi Hapus</h3>
                <button type="button" class="close-btn" wire:click="closeModal">&times;</button>
            </div>
            
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus kategori ini? Tindakan ini tidak dapat dibatalkan.</p>
                <p class="warning-text">Note: Jika kategori memiliki barang, penghapusan mungkin akan gagal.</p>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModal">Batal</button>
                <button type="button" class="btn btn-danger" wire:click="deleteKategori" wire:loading.attr="disabled">
                    <span wire:loading.remove>Hapus</span>
                    <span wire:loading>Loading...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    <style>
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .modal-header {
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            padding: 20px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #6b7280;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-control:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .error-text {
            color: #dc2626;
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }

        .warning-text {
            color: #d97706;
            font-size: 12px;
            font-style: italic;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-primary {
            background: #4f46e5;
            color: white;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .kategori-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .kategori-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            background: #4f46e5;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .deskripsi-text {
            color: #6b7280;
            font-size: 14px;
        }
        
        .item-count {
            background: #dbeafe;
            color: #1d4ed8;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
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
            transition: all 0.2s;
        }
        
        .action-btn:hover {
            transform: translateY(-1px);
        }
        
        .action-btn.edit {
            background: #dbeafe;
            color: #1d4ed8;
        }
        
        .action-btn.delete {
            background: #fee2e2;
            color: #dc2626;
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            background: #4f46e5;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        
        .stat-info h3 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
        }
        
        .stat-info p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</div>