<div>
    <div class="content">
        <div class="page-header">
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">Overview sistem manajemen inventory</p>
        </div>

        <!-- Main Stats Grid -->
        <div class="stats-grid">
            <!-- Users Stats -->
            <div class="stat-section">
                <h3 class="section-title">
                    <i class="fas fa-users"></i>
                    Statistik Pengguna
                </h3>
                <div class="stats-container">
                    <div class="stat-card">
                        <div class="stat-icon user-stat">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $totalUsers }}</h3>
                            <p>Total Pengguna</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon admin-stat">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $totalAdmins }}</h3>
                            <p>Admin</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon user-regular-stat">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $totalRegularUsers }}</h3>
                            <p>User Biasa</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon new-user-stat">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $newUsersToday }}</h3>
                            <p>Baru Hari Ini</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kategori Stats -->
            <div class="stat-section">
                <h3 class="section-title">
                    <i class="fas fa-tags"></i>
                    Statistik Kategori
                </h3>
                <div class="stats-container">
                    <div class="stat-card">
                        <div class="stat-icon kategori-stat">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $totalKategoris }}</h3>
                            <p>Total Kategori</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon active-kategori-stat">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $kategorisWithBarang }}</h3>
                            <p>Kategori Aktif</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon empty-kategori-stat">
                            <i class="fas fa-cube"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $emptyKategoris }}</h3>
                            <p>Kategori Kosong</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon new-kategori-stat">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $newKategorisToday }}</h3>
                            <p>Baru Hari Ini</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Barang Stats -->
            <div class="stat-section">
                <h3 class="section-title">
                    <i class="fas fa-cubes"></i>
                    Statistik Barang
                </h3>
                <div class="stats-container">
                    <div class="stat-card">
                        <div class="stat-icon barang-stat">
                            <i class="fas fa-cubes"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $totalBarangs }}</h3>
                            <p>Total Barang</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon stok-stat">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ number_format($totalStok) }}</h3>
                            <p>Total Stok</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon out-of-stock-stat">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $outOfStock }}</h3>
                            <p>Stok Habis</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon low-stock-stat">
                            <i class="fas fa-thermometer-half"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $lowStock }}</h3>
                            <p>Stok Sedikit</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Stats -->
            <div class="stat-section">
                <h3 class="section-title">
                    <i class="fas fa-chart-line"></i>
                    Statistik Keuangan
                </h3>
                <div class="stats-container">
                    <div class="stat-card">
                        <div class="stat-icon financial-stat">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Rp {{ number_format($totalNilaiStok, 0, ',', '.') }}</h3>
                            <p>Total Nilai Stok</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon revenue-stat">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Rp {{ number_format($totalPotensiPendapatan, 0, ',', '.') }}</h3>
                            <p>Potensi Pendapatan</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon profit-stat">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Rp {{ number_format($totalPotensiKeuntungan, 0, ',', '.') }}</h3>
                            <p>Potensi Keuntungan</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon new-barang-stat">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $newBarangsToday }}</h3>
                            <p>Barang Baru Hari Ini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-grid">
            <!-- Stok per Kategori -->
            <div class="chart-card">
                <div class="chart-header">
                    <h4>
                        <i class="fas fa-chart-bar text-primary"></i>
                        Stok per Kategori
                    </h4>
                    <p>Distribusi stok barang berdasarkan kategori</p>
                </div>
                <div class="chart-container">
                    <canvas id="stokPerKategoriChart" width="400" height="250"></canvas>
                </div>
            </div>

            <!-- Trend Barang Bulanan -->
            <div class="chart-card">
                <div class="chart-header">
                    <h4>
                        <i class="fas fa-chart-line text-success"></i>
                        Trend Barang Bulanan
                    </h4>
                    <p>Penambahan barang sepanjang tahun {{ date('Y') }}</p>
                </div>
                <div class="chart-container">
                    <canvas id="monthlyBarangChart" width="400" height="250"></canvas>
                </div>
            </div>

            <!-- Status Stok -->
            <div class="chart-card">
                <div class="chart-header">
                    <h4>
                        <i class="fas fa-chart-pie text-warning"></i>
                        Status Stok Barang
                    </h4>
                    <p>Persentase kondisi stok barang</p>
                </div>
                <div class="chart-container">
                    <canvas id="stokStatusChart" width="400" height="250"></canvas>
                </div>
            </div>

            <!-- Harga Rata-rata per Kategori -->
            <div class="chart-card">
                <div class="chart-header">
                    <h4>
                        <i class="fas fa-money-bill-wave text-info"></i>
                        Harga Rata-rata per Kategori
                    </h4>
                    <p>Perbandingan harga jual rata-rata</p>
                </div>
                <div class="chart-container">
                    <canvas id="avgPriceChart" width="400" height="250"></canvas>
                </div>
            </div>

            <!-- Registrasi User -->
            <div class="chart-card">
                <div class="chart-header">
                    <h4>
                        <i class="fas fa-user-plus text-purple"></i>
                        Registrasi User
                    </h4>
                    <p>Trend registrasi user tahun {{ date('Y') }}</p>
                </div>
                <div class="chart-container">
                    <canvas id="userRegistrationsChart" width="400" height="250"></canvas>
                </div>
            </div>

            <!-- Ringkasan Performa -->
            <div class="chart-card">
                <div class="chart-header">
                    <h4>
                        <i class="fas fa-tachometer-alt text-danger"></i>
                        Ringkasan Performa
                    </h4>
                    <p>Metrik utama sistem</p>
                </div>
                <div class="performance-metrics">
                    <div class="metric-item">
                        <div class="metric-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="metric-info">
                            <span class="metric-value">{{ $totalBarangs }}</span>
                            <span class="metric-label">Total Barang</span>
                        </div>
                    </div>
                    <div class="metric-item">
                        <div class="metric-icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="metric-info">
                            <span class="metric-value">{{ number_format($totalStok) }}</span>
                            <span class="metric-label">Total Stok</span>
                        </div>
                    </div>
                    <div class="metric-item">
                        <div class="metric-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="metric-info">
                            <span class="metric-value">{{ $totalKategoris }}</span>
                            <span class="metric-label">Kategori</span>
                        </div>
                    </div>
                    <div class="metric-item">
                        <div class="metric-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="metric-info">
                            <span class="metric-value">{{ $totalUsers }}</span>
                            <span class="metric-label">Pengguna</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information Grid -->
        <div class="info-grid">
            <!-- Low Stock Items -->
            <div class="info-card">
                <div class="info-card-header">
                    <h4>
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                        Barang Stok Sedikit
                    </h4>
                    <span class="badge badge-warning">{{ $lowestStockItems->count() }}</span>
                </div>
                <div class="info-card-body">
                    @forelse($lowestStockItems as $item)
                    <div class="info-item">
                        <div class="info-item-main">
                            <strong>{{ $item->barang }}</strong>
                            <span class="info-item-category">{{ $item->kategori->name }}</span>
                        </div>
                        <div class="info-item-meta">
                            <span class="stok-badge stok-sedikit">{{ $item->stok }} {{ $item->satuan }}</span>
                            <small>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</small>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-check-circle fa-2x mb-2"></i>
                        <p>Semua stok aman</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Top Categories -->
            <div class="info-card">
                <div class="info-card-header">
                    <h4>
                        <i class="fas fa-trophy text-primary"></i>
                        Kategori Terpopuler
                    </h4>
                    <span class="badge badge-primary">{{ $topKategoris->count() }}</span>
                </div>
                <div class="info-card-body">
                    @forelse($topKategoris as $kategori)
                    <div class="info-item">
                        <div class="info-item-main">
                            <strong>{{ $kategori->name }}</strong>
                            <span class="info-item-description">{{ Str::limit($kategori->deskripsi, 30) }}</span>
                        </div>
                        <div class="info-item-meta">
                            <span class="item-count">{{ $kategori->barangs_count }} barang</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-folder-open fa-2x mb-2"></i>
                        <p>Belum ada kategori</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Barangs -->
            <div class="info-card">
                <div class="info-card-header">
                    <h4>
                        <i class="fas fa-clock text-info"></i>
                        Barang Terbaru
                    </h4>
                    <span class="badge badge-info">{{ $recentBarangs->count() }}</span>
                </div>
                <div class="info-card-body">
                    @forelse($recentBarangs as $barang)
                    <div class="info-item">
                        <div class="info-item-main">
                            <strong>{{ $barang->barang }}</strong>
                            <span class="info-item-category">{{ $barang->kategori->name }}</span>
                        </div>
                        <div class="info-item-meta">
                            <span class="stok-badge @if($barang->stok == 0) stok-kosong @elseif($barang->stok < 10) stok-sedikit @else stok-cukup @endif">
                                {{ $barang->stok }} {{ $barang->satuan }}
                            </span>
                            <small>{{ $barang->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-cube fa-2x mb-2"></i>
                        <p>Belum ada barang</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('livewire:init', function () {
            // Stok per Kategori Chart
            const stokPerKategoriCtx = document.getElementById('stokPerKategoriChart').getContext('2d');
            new Chart(stokPerKategoriCtx, {
                type: 'bar',
                data: {
                    labels: @json($chartData['stokPerKategori']['labels']),
                    datasets: [{
                        label: 'Total Stok',
                        data: @json($chartData['stokPerKategori']['data']),
                        backgroundColor: @json($chartData['stokPerKategori']['colors']),
                        borderColor: @json($chartData['stokPerKategori']['colors']),
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Stok: ${context.parsed.y}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Monthly Barang Chart
            const monthlyBarangCtx = document.getElementById('monthlyBarangChart').getContext('2d');
            new Chart(monthlyBarangCtx, {
                type: 'line',
                data: {
                    labels: @json($chartData['monthlyBarang']['labels']),
                    datasets: [{
                        label: 'Jumlah Barang',
                        data: @json($chartData['monthlyBarang']['data']),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Stok Status Chart
            const stokStatusCtx = document.getElementById('stokStatusChart').getContext('2d');
            new Chart(stokStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($chartData['stokStatus']['labels']),
                    datasets: [{
                        data: @json($chartData['stokStatus']['data']),
                        backgroundColor: @json($chartData['stokStatus']['colors']),
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Average Price Chart
            const avgPriceCtx = document.getElementById('avgPriceChart').getContext('2d');
            new Chart(avgPriceCtx, {
                type: 'radar',
                data: {
                    labels: @json($chartData['avgPricePerKategori']['labels']),
                    datasets: [{
                        label: 'Harga Rata-rata',
                        data: @json($chartData['avgPricePerKategori']['data']),
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: '#3b82f6',
                        borderWidth: 2,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        r: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });

            // User Registrations Chart
            const userRegistrationsCtx = document.getElementById('userRegistrationsChart').getContext('2d');
            new Chart(userRegistrationsCtx, {
                type: 'bar',
                data: {
                    labels: @json($chartData['userRegistrations']['labels']),
                    datasets: [{
                        label: 'Registrasi User',
                        data: @json($chartData['userRegistrations']['data']),
                        backgroundColor: 'rgba(139, 92, 246, 0.7)',
                        borderColor: '#8b5cf6',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>

    <style>
        /* Previous styles remain the same, add these new styles */

        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .chart-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 20px;
            transition: transform 0.3s ease;
        }

        .chart-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        }

        .chart-header {
            margin-bottom: 20px;
        }

        .chart-header h4 {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0 0 5px 0;
            font-size: 16px;
            font-weight: 600;
            color: #374151;
        }

        .chart-header p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }

        .chart-container {
            position: relative;
            height: 250px;
            width: 100%;
        }

        .performance-metrics {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .metric-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            background: #f8fafc;
            border-radius: 8px;
            border-left: 4px solid #4f46e5;
        }

        .metric-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: #4f46e5;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .metric-info {
            flex: 1;
        }

        .metric-value {
            display: block;
            font-size: 20px;
            font-weight: bold;
            color: #1f2937;
        }

        .metric-label {
            font-size: 12px;
            color: #6b7280;
        }

        .text-purple {
            color: #8b5cf6;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .charts-grid {
                grid-template-columns: 1fr;
            }
            
            .chart-card {
                padding: 15px;
            }
            
            .performance-metrics {
                grid-template-columns: 1fr;
            }
        }

        /* Updated color scheme to match user management example */
        .content { padding: 20px; }
        .page-header { margin-bottom: 30px; }
        .page-title { font-size: 28px; font-weight: bold; color: #1f2937; margin: 0; }
        .page-subtitle { color: #6b7280; margin: 5px 0 0 0; }
        .stats-grid { display: flex; flex-direction: column; gap: 25px; margin-bottom: 30px; }
        .stat-section { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .section-title { display: flex; align-items: center; gap: 10px; font-size: 18px; font-weight: 600; color: #374151; margin: 0 0 20px 0; padding-bottom: 15px; border-bottom: 2px solid #f3f4f6; }
        .stats-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .stat-card { display: flex; align-items: center; gap: 15px; padding: 15px; background: #f8fafc; border-radius: 8px; border-left: 4px solid; transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .stat-icon { width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; color: white; }
        
        /* User stats - Blue theme matching user management example */
        .user-stat { background: #4f46e5; border-left-color: #4f46e5; }
        .admin-stat { background: #6366f1; border-left-color: #6366f1; }
        .user-regular-stat { background: #818cf8; border-left-color: #818cf8; }
        .new-user-stat { background: #a5b4fc; border-left-color: #a5b4fc; }
        
        /* Category stats - Orange/Yellow theme */
        .kategori-stat { background: #f59e0b; border-left-color: #f59e0b; }
        .active-kategori-stat { background: #fbbf24; border-left-color: #fbbf24; }
        .empty-kategori-stat { background: #fcd34d; border-left-color: #fcd34d; }
        .new-kategori-stat { background: #fde68a; border-left-color: #fde68a; }
        
        /* Item stats - Green theme */
        .barang-stat { background: #10b981; border-left-color: #10b981; }
        .stok-stat { background: #34d399; border-left-color: #34d399; }
        .out-of-stock-stat { background: #ef4444; border-left-color: #ef4444; }
        .low-stock-stat { background: #f59e0b; border-left-color: #f59e0b; }
        
        /* Financial stats - Purple theme */
        .financial-stat { background: #8b5cf6; border-left-color: #8b5cf6; }
        .revenue-stat { background: #a78bfa; border-left-color: #a78bfa; }
        .profit-stat { background: #c4b5fd; border-left-color: #c4b5fd; }
        .new-barang-stat { background: #ddd6fe; border-left-color: #ddd6fe; color: #6b7280; }
        
        .stat-info h3 { margin: 0; font-size: 24px; font-weight: bold; color: #1f2937; }
        .stat-info p { margin: 5px 0 0 0; color: #6b7280; font-size: 14px; }
        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 25px; }
        .info-card { background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); overflow: hidden; }
        .info-card-header { display: flex; align-items: center; justify-content: space-between; padding: 20px; background: #f8fafc; border-bottom: 1px solid #e5e7eb; }
        .info-card-header h4 { display: flex; align-items: center; gap: 10px; margin: 0; font-size: 16px; font-weight: 600; color: #374151; }
        .badge { padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        .badge-warning { background: #fef3c7; color: #d97706; }
        .badge-primary { background: #dbeafe; color: #1d4ed8; }
        .badge-info { background: #d1fae5; color: #059669; }
        .info-card-body { padding: 0; }
        .info-item { display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #f3f4f6; transition: background-color 0.2s; }
        .info-item:hover { background: #f9fafb; }
        .info-item:last-child { border-bottom: none; }
        .info-item-main { flex: 1; }
        .info-item-main strong { display: block; font-size: 14px; color: #374151; margin-bottom: 2px; }
        .info-item-category, .info-item-description { font-size: 12px; color: #6b7280; }
        .info-item-meta { display: flex; flex-direction: column; align-items: flex-end; gap: 4px; }
        .stok-badge { padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; }
        .stok-kosong { background: #fee2e2; color: #dc2626; }
        .stok-sedikit { background: #fef3c7; color: #d97706; }
        .stok-cukup { background: #d1fae5; color: #059669; }
        .item-count { background: #dbeafe; color: #1d4ed8; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; }
        .text-muted { color: #9ca3af !important; }

        @media (max-width: 768px) {
            .stats-container { grid-template-columns: 1fr; }
            .info-grid { grid-template-columns: 1fr; }
            .stat-card { flex-direction: column; text-align: center; }
        }
    </style>
</div>