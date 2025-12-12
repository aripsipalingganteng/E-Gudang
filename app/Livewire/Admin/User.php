<?php

namespace App\Livewire\Admin;
use App\Models\User as ModelsUser;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class User extends Component
{
   use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $name, $email, $password, $role = 'user', $profile_photo;
    public $userId, $editMode = false;
    public $search = '';
    public $confirmingDelete = false;
    public $userToDelete;
    public $showModal = false;
    public $exportType = 'pdf';
    public $startDate;
    public $endDate;
    public $selectedRole = 'all';


      protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,user',
            'profile_photo' => 'nullable|image|max:2048',
        ];

        if ($this->editMode) {
            $rules['email'] = 'required|email|unique:users,email,' . $this->userId;
            $rules['password'] = 'nullable|min:8';
        } else {
            $rules['email'] = 'required|email|unique:users,email';
            $rules['password'] = 'required|min:8';
        }

        return $rules;
    }

      public function render()
    {
        $users = $this->getFilteredUsers();
        return view('livewire.admin.user', compact('users'));
    }

    public function create()
    {
        $this->resetInput();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function store()
    {
        $validatedData = $this->validate();

        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];

        if ($this->password) {
            $userData['password'] = Hash::make($this->password);
        }

        // Handle profile photo upload
        if ($this->profile_photo) {
            $photoPath = $this->profile_photo->store('profile-photos', 'public');
            $userData['profile_photo_path'] = $photoPath;
        }

        if ($this->editMode) {
            $user = ModelsUser::find($this->userId);
            $user->update($userData);
            session()->flash('message', 'User berhasil diupdate!');
        } else {
            ModelsUser::create($userData);
            session()->flash('message', 'User berhasil ditambahkan!');
        }

        $this->showModal = false;
        $this->resetInput();
    }

    private function getFilteredUsers()
    {
        return ModelsUser::when($this->search, function ($query) {
            return $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
        })
        ->when($this->selectedRole !== 'all', function ($query) {
            return $query->where('role', $this->selectedRole);
        })
        ->when($this->startDate && $this->endDate, function ($query) {
            return $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        })
        ->latest()
        ->paginate(10);
    }


    public function edit($id)
    {
        $user = ModelsUser::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = '';
        $this->profile_photo = null;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function confirmDelete($id)
    {
        $this->userToDelete = $id;
        $this->confirmingDelete = true;
    }

    public function destroy()
    {
        $user = ModelsUser::findOrFail($this->userToDelete);
        
        // Delete profile photo if exists
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }
        
        $user->delete();
        
        $this->confirmingDelete = false;
        session()->flash('message', 'User berhasil dihapus!');
    }

    public function exportPDF()
    {
        $users = $this->getFilteredUsersForExport();
        $title = 'Laporan Data User';
        
        $pdf = Pdf::loadView('exports.users-pdf', [
            'users' => $users,
            'title' => $title,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'role' => $this->selectedRole,
        ]);
        
        $filename = 'users-report-' . date('Y-m-d-H-i-s') . '.pdf';
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename);
    }

    public function exportExcel()
    {
        $users = $this->getFilteredUsersForExport();
        $filename = 'users-report-' . date('Y-m-d-H-i-s') . '.xlsx';
        
        return Excel::download(new UsersExport($users), $filename);
    }

    private function getFilteredUsersForExport()
    {
        return ModelsUser::when($this->search, function ($query) {
            return $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
        })
        ->when($this->selectedRole !== 'all', function ($query) {
            return $query->where('role', $this->selectedRole);
        })
        ->when($this->startDate && $this->endDate, function ($query) {
            return $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        })
        ->latest()
        ->get();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->startDate = null;
        $this->endDate = null;
        $this->selectedRole = 'all';
    }
    
    public function closeModal()
    {
        $this->showModal = false;
        $this->confirmingDelete = false;
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = 'user';
        $this->profile_photo = null;
        $this->userId = null;
        $this->editMode = false;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
}