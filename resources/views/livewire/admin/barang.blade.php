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
            <h1 class="page-title">Manajemen Barang</h1>
            <p class="page-subtitle">Kelola data barang dengan mudah dan efisien</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-cubes"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ \App\Models\Barang::count() }}</h3>
                    <p>Total Barang</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ \App\Models\Barang::sum('stok') }}</h3>
                    <p>Total Stok</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-info">
                    <h3>Rp {{ number_format(\App\Models\Barang::get()->sum(function($item) { return $item->harga_beli * $item->stok; }), 0, ',', '.') }}</h3>
                    <p>Total Nilai Stok</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ \App\Models\Barang::whereDate('created_at', today())->count() }}</h3>
                    <p>Baru Hari Ini</p>
                </div>
            </div>
        </div>
        
        <!-- Barang Table -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Daftar Barang</h2>
                <div class="card-actions">
                    <div class="search-box">
                        <input type="text" wire:model.live="search" placeholder="Cari barang..." class="form-control">
                        <i class="fas fa-search"></i>
                    </div>
                    <button class="btn btn-primary" wire:click="create" wire:loading.attr="disabled">
                        <i class="fas fa-plus"></i> 
                        <span wire:loading.remove>Tambah Barang</span>
                        <span wire:loading>Loading...</span>
                    </button>
                </div>
            </div>
            
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Satuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangs as $barang)
                        <tr>
                            <td>{{ $loop->iteration + ($barangs->currentPage() - 1) * $barangs->perPage() }}</td>
                            <td>
                                <div class="barang-info">
                                    <div class="barang-icon">
                                        <i class="fas fa-cube"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $barang->barang }}</strong>
                                        <br>
                                        <small class="deskripsi-text">{{ Str::limit($barang->deskripsi, 30) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-category">{{ $barang->kategori->name }}</span>
                            </td>
                            <td>
                                <span class="harga-beli">{{ $barang->harga_beli_formatted }}</span>
                            </td>
                            <td>
                                <span class="harga-jual">{{ $barang->harga_jual_formatted }}</span>
                            </td>
                            <td>
                                <span class="stok-badge @if($barang->stok == 0) stok-kosong @elseif($barang->stok < 10) stok-sedikit @else stok-cukup @endif">
                                    {{ $barang->stok }}
                                </span>
                            </td>
                            <td>
                                <span class="satuan-text">{{ $barang->satuan }}</span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit" wire:click="edit({{ $barang->id }})" wire:loading.attr="disabled" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn delete" wire:click="confirmDelete({{ $barang->id }})" wire:loading.attr="disabled" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data barang</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer">
                {{ $barangs->links() }}
            </div>
        </div>
    </div>

    <!-- Barang Modal -->
    @if($showModal)
    <div class="modal-overlay">
        <div class="modal-content" style="max-width: 600px;">
            <div class="modal-header">
                <h3>{{ $editMode ? 'Edit Barang' : 'Tambah Barang Baru' }}</h3>
                <button type="button" class="close-btn" wire:click="closeModal">&times;</button>
            </div>
            
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Nama Barang *</label>
                        <input type="text" wire:model="barang" class="form-control" placeholder="Masukkan nama barang">
                        @error('barang') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label>Kategori *</label>
                        <select wire:model="kategori_id" class="form-control">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Harga Beli *</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" wire:model="harga_beli" class="form-control" placeholder="0" min="0">
                        </div>
                        @error('harga_beli') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label>Harga Jual *</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" wire:model="harga_jual" class="form-control" placeholder="0" min="0">
                        </div>
                        @error('harga_jual') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Stok *</label>
                        <input type="number" wire:model="stok" class="form-control" placeholder="0" min="0">
                        @error('stok') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label>Satuan *</label>
                        <select wire:model="satuan" class="form-control">
                            <option value="">Pilih Satuan</option>
                            @foreach($satuans as $satuan)
                                <option value="{{ $satuan }}">{{ $satuan }}</option>
                            @endforeach
                        </select>
                        @error('satuan') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label>Keuntungan</label>
                        <input type="text" class="form-control" value="{{ $harga_jual && $harga_beli ? 'Rp ' . number_format($harga_jual - $harga_beli, 0, ',', '.') : 'Rp 0' }}" readonly style="background-color: #f8f9fa;">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Deskripsi *</label>
                    <textarea wire:model="deskripsi" class="form-control" rows="3" placeholder="Masukkan deskripsi barang"></textarea>
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
                <p>Apakah Anda yakin ingin menghapus barang ini? Tindakan ini tidak dapat dibatalkan.</p>
                <p class="warning-text">Note: Data transaksi yang terkait dengan barang ini mungkin akan terpengaruh.</p>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModal">Batal</button>
                <button type="button" class="btn btn-danger" wire:click="deleteBarang" wire:loading.attr="disabled">
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
            color: #059669;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #059669;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-control:focus {
            outline: none;
            border-color: #059669;
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
            background: #059669;
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

        .barang-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .barang-icon {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            background: #059669;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .deskripsi-text {
            color: #6b7280;
            font-size: 12px;
        }
        
        .badge-category {
            background: #dbeafe;
            color: #059669;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .harga-beli {
            color: #dc2626;
            font-weight: 500;
        }
        
        .harga-jual {
            color: #059669;
            font-weight: 500;
        }
        
        .stok-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .stok-kosong {
            background: #fee2e2;
            color: #dc2626;
        }
        
        .stok-sedikit {
            background: #fef3c7;
            color: #d97706;
        }
        
        .stok-cukup {
            background: #d1fae5;
            color: #059669;
        }
        
        .satuan-text {
            background: #f3f4f6;
            color: #374151;
            padding: 4px 8px;
            border-radius: 6px;
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
            color: #059669;
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
            background: #059669;
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

        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -5px;
            margin-left: -5px;
        }

        .form-row > .form-group {
            padding-right: 5px;
            padding-left: 5px;
        }

        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-md-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .input-group {
            position: relative;
            display: flex;
            flex-wrap: wrap;
            align-items: stretch;
            width: 100%;
        }

        .input-group-prepend {
            margin-right: -1px;
        }

        .input-group-text {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.5;
            color: #6b7280;
            text-align: center;
            white-space: nowrap;
            background-color: #f9fafb;
            border: 1px solid #d1d5db;
            border-radius: 4px 0 0 4px;
        }
    </style>
</div>