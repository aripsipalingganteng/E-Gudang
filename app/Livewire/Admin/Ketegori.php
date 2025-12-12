<?php

namespace App\Livewire\Admin;

use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithPagination;

class Ketegori extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $name, $deskripsi;
    public $kategoriId, $editMode = false;
    public $search = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $kategoriToDelete;

    protected $rules = [
        'name' => 'required|string|max:255|unique:kategoris,name',
        'deskripsi' => 'required|string|max:500',
    ];

    protected $validationAttributes = [
        'name' => 'nama kategori',
        'deskripsi' => 'deskripsi',
    ];

    // Reset page ketika search berubah
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $kategoris = Kategori::when($this->search, function ($query) {
            return $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
            });
        })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.ketegori', compact('kategoris'));
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
            $kategori = Kategori::findOrFail($id);

            $this->resetErrorBag();
            $this->kategoriId = $kategori->id;
            $this->name = $kategori->name;
            $this->deskripsi = $kategori->deskripsi;
            $this->editMode = true;
            $this->showModal = true;

        } catch (\Exception $e) {
            session()->flash('error', 'Kategori tidak ditemukan!');
        }
    }

    public function save()
    {
        // validasi unique saat update
        if ($this->editMode) {
            $this->rules['name'] = 'required|string|max:255|unique:kategoris,name,' . $this->kategoriId;
        }

        $this->validate();

        $data = [
            'name' => $this->name,
            'deskripsi' => $this->deskripsi,
        ];

        try {
            if ($this->editMode) {
                Kategori::findOrFail($this->kategoriId)->update($data);
                session()->flash('message', 'Kategori berhasil diupdate!');
            } else {
                Kategori::create($data);
                session()->flash('message', 'Kategori berhasil ditambahkan!');
            }

            $this->closeModal();

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function confirmDelete($id)
    {
        $this->kategoriToDelete = $id;
        $this->showDeleteModal = true;
    }

    public function deleteKategori()
    {
        try {
            Kategori::findOrFail($this->kategoriToDelete)->delete();

            $this->showDeleteModal = false;
            session()->flash('message', 'Kategori berhasil dihapus!');

        } catch (\Exception $e) {
            session()->flash('error', 'Tidak dapat menghapus kategori: ' . $e->getMessage());
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
        $this->name = '';
        $this->deskripsi = '';
        $this->kategoriId = null;
        $this->editMode = false;
        $this->kategoriToDelete = null;
    }

    // validasi real-time
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
}