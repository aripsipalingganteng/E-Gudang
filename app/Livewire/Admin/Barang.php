<?php

namespace App\Livewire\Admin;

use App\Models\Barang as ModelsBarang;
use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithPagination;

class Barang extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $barang, $kategori_id, $harga_beli, $harga_jual, $stok, $satuan, $deskripsi;
    public $barangId, $editMode = false;
    public $search = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $barangToDelete;

    public $satuans = ['pcs', 'unit', 'pack', 'dus', 'kg', 'gram', 'meter', 'liter'];

    protected $rules = [
        'barang' => 'required|string|max:255',
        'kategori_id' => 'required|exists:kategoris,id',
        'harga_beli' => 'required|integer|min:0',
        'harga_jual' => 'required|integer|min:0',
        'stok' => 'required|integer|min:0',
        'satuan' => 'required|string|max:50',
        'deskripsi' => 'required|string|max:500',
    ];

    protected $validationAttributes = [
        'barang' => 'nama barang',
        'kategori_id' => 'kategori',
        'harga_beli' => 'harga beli',
        'harga_jual' => 'harga jual',
        'stok' => 'stok',
        'satuan' => 'satuan',
        'deskripsi' => 'deskripsi',
    ];

    // Reset page ketika search berubah
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // Validasi harga jual harus lebih besar dari harga beli
    public function updatedHargaJual()
    {
        if ($this->harga_jual && $this->harga_beli && $this->harga_jual <= $this->harga_beli) {
            $this->addError('harga_jual', 'Harga jual harus lebih besar dari harga beli.');
        }
    }

    public function render()
    {
        $barangs = ModelsBarang::with('kategori')
            ->when($this->search, function ($query) {
                return $query->where(function ($q) {
                    $q->where('barang', 'like', '%' . $this->search . '%')
                      ->orWhere('deskripsi', 'like', '%' . $this->search . '%')
                      ->orWhereHas('kategori', function ($kategoriQuery) {
                          $kategoriQuery->where('name', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->latest()
            ->paginate(10);

        $kategoris = Kategori::all();

        return view('livewire.admin.barang', compact('barangs', 'kategoris'));
    }

    public function create()
    {
        $this->resetInput();
        $this->resetErrorBag();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        try {
            $barang = ModelsBarang::findOrFail($id);

            $this->resetErrorBag();
            $this->barangId = $barang->id;
            $this->barang = $barang->barang;
            $this->kategori_id = $barang->kategori_id;
            $this->harga_beli = $barang->harga_beli;
            $this->harga_jual = $barang->harga_jual;
            $this->stok = $barang->stok;
            $this->satuan = $barang->satuan;
            $this->deskripsi = $barang->deskripsi;
            $this->editMode = true;
            $this->showModal = true;

        } catch (\Exception $e) {
            session()->flash('error', 'Barang tidak ditemukan!');
        }
    }

    public function save()
    {
        // Validasi tambahan untuk harga jual
        $this->rules['harga_jual'] = 'required|integer|min:' . ($this->harga_beli + 1);

        $this->validate();

        $data = [
            'barang' => $this->barang,
            'kategori_id' => $this->kategori_id,
            'harga_beli' => $this->harga_beli,
            'harga_jual' => $this->harga_jual,
            'stok' => $this->stok,
            'satuan' => $this->satuan,
            'deskripsi' => $this->deskripsi,
        ];

        try {
            if ($this->editMode) {
                ModelsBarang::findOrFail($this->barangId)->update($data);
                session()->flash('message', 'Barang berhasil diupdate!');
            } else {
                ModelsBarang::create($data);
                session()->flash('message', 'Barang berhasil ditambahkan!');
            }

            $this->closeModal();

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function confirmDelete($id)
    {
        $this->barangToDelete = $id;
        $this->showDeleteModal = true;
    }

    public function deleteBarang()
    {
        try {
            ModelsBarang::findOrFail($this->barangToDelete)->delete();

            $this->showDeleteModal = false;
            session()->flash('message', 'Barang berhasil dihapus!');

        } catch (\Exception $e) {
            session()->flash('error', 'Tidak dapat menghapus barang: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->resetInput();
        $this->resetErrorBag();
    }

    private function resetInput()
    {
        $this->barang = '';
        $this->kategori_id = '';
        $this->harga_beli = '';
        $this->harga_jual = '';
        $this->stok = '';
        $this->satuan = '';
        $this->deskripsi = '';
        $this->barangId = null;
        $this->editMode = false;
        $this->barangToDelete = null;
    }

    // validasi real-time
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
}