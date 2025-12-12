<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Barang;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $chartData = [];

    public function mount()
    {
        $this->prepareChartData();
    }

    private function prepareChartData()
    {
        // Data untuk grafik stok barang per kategori
        $stokPerKategori = Kategori::withSum('barangs', 'stok')
            ->having('barangs_sum_stok', '>', 0)
            ->orderBy('barangs_sum_stok', 'desc')
            ->limit(8)
            ->get();

        $this->chartData['stokPerKategori'] = [
            'labels' => $stokPerKategori->pluck('name')->toArray(),
            'data' => $stokPerKategori->pluck('barangs_sum_stok')->toArray(),
            'colors' => [
                '#4f46e5', '#10b981', '#f59e0b', '#ef4444', 
                '#8b5cf6', '#06b6d4', '#84cc16', '#f97316'
            ]
        ];

        // Data untuk grafik trend barang bulanan
        $monthlyBarang = Barang::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = [];
        $monthlyData = array_fill(1, 12, 0);
        
        foreach ($monthlyBarang as $data) {
            $monthlyData[$data->month] = $data->count;
        }

        $this->chartData['monthlyBarang'] = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            'data' => array_values($monthlyData)
        ];

        // Data untuk grafik harga rata-rata per kategori
        $avgPricePerKategori = Kategori::withAvg('barangs', 'harga_jual')
            ->having('barangs_avg_harga_jual', '>', 0)
            ->orderBy('barangs_avg_harga_jual', 'desc')
            ->limit(6)
            ->get();

        $this->chartData['avgPricePerKategori'] = [
            'labels' => $avgPricePerKategori->pluck('name')->toArray(),
            'data' => $avgPricePerKategori->pluck('barangs_avg_harga_jual')->toArray()
        ];

        // Data untuk grafik status stok
        $stokStatus = [
            'Stok Aman' => Barang::where('stok', '>', 10)->count(),
            'Stok Sedikit' => Barang::where('stok', '>', 0)->where('stok', '<=', 10)->count(),
            'Stok Habis' => Barang::where('stok', 0)->count()
        ];

        $this->chartData['stokStatus'] = [
            'labels' => array_keys($stokStatus),
            'data' => array_values($stokStatus),
            'colors' => ['#10b981', '#f59e0b', '#ef4444']
        ];

        // Data untuk grafik user registration
        $userRegistrations = User::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $userMonthlyData = array_fill(1, 12, 0);
        
        foreach ($userRegistrations as $data) {
            $userMonthlyData[$data->month] = $data->count;
        }

        $this->chartData['userRegistrations'] = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            'data' => array_values($userMonthlyData)
        ];
    }

    public function render()
    {
        // Statistik Users
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalRegularUsers = User::where('role', 'user')->count();
        $newUsersToday = User::whereDate('created_at', today())->count();

        // Statistik Kategoris
        $totalKategoris = Kategori::count();
        $kategorisWithBarang = Kategori::has('barangs')->count();
        $emptyKategoris = Kategori::doesntHave('barangs')->count();
        $newKategorisToday = Kategori::whereDate('created_at', today())->count();

        // Statistik Barangs
        $totalBarangs = Barang::count();
        $totalStok = Barang::sum('stok');
        $outOfStock = Barang::where('stok', 0)->count();
        $lowStock = Barang::where('stok', '>', 0)->where('stok', '<=', 10)->count();
        $newBarangsToday = Barang::whereDate('created_at', today())->count();

        // Nilai stok total (harga beli * stok)
        $totalNilaiStok = Barang::get()->sum(function($item) {
            return $item->harga_beli * $item->stok;
        });

        // Total potensi pendapatan (harga jual * stok)
        $totalPotensiPendapatan = Barang::get()->sum(function($item) {
            return $item->harga_jual * $item->stok;
        });

        // Total potensi keuntungan
        $totalPotensiKeuntungan = $totalPotensiPendapatan - $totalNilaiStok;

        // Barang dengan stok terendah
        $lowestStockItems = Barang::with('kategori')
            ->where('stok', '>', 0)
            ->orderBy('stok', 'asc')
            ->limit(5)
            ->get();

        // Kategori dengan barang terbanyak
        $topKategoris = Kategori::withCount('barangs')
            ->orderBy('barangs_count', 'desc')
            ->limit(5)
            ->get();

        // Barang terbaru
        $recentBarangs = Barang::with('kategori')
            ->latest()
            ->limit(5)
            ->get();

        return view('livewire.admin.dashboard', compact(
            'totalUsers',
            'totalAdmins',
            'totalRegularUsers',
            'newUsersToday',
            'totalKategoris',
            'kategorisWithBarang',
            'emptyKategoris',
            'newKategorisToday',
            'totalBarangs',
            'totalStok',
            'outOfStock',
            'lowStock',
            'newBarangsToday',
            'totalNilaiStok',
            'totalPotensiPendapatan',
            'totalPotensiKeuntungan',
            'lowestStockItems',
            'topKategoris',
            'recentBarangs'
        ));
    }
}