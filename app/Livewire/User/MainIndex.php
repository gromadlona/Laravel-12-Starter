<?php

namespace App\Livewire\User;

use App\Helpers\MainHelper;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class MainIndex extends Component
{
    use WithPagination;

    // Form State
    #[Locked]
    public $form = false;

    public $state = [];

    #[Locked]
    public $params = [
        'name' => null,
        'email' => null,
        'password' => null,
        'password_confirmation' => null,
        'roles' => null,
    ];

    #[Locked]
    public ?User $editData;
    // End Form State

    // Static Data 
    #[Locked]
    public $staticData = [
        'roles' => []
    ];
    // End Static Data

    public function mount()
    {
        $this->state = $this->params;
        $this->getStaticData();
    }

    public function getStaticData()
    {
        try {
            $getRoles = Role::whereNotIn('name', ['MeGGi'])->get();
            $this->staticData['roles'] = $getRoles;
        } catch (\Throwable $th) {
            (new MainHelper)->doAlert(0);
        }
    }

    public function render()
    {
        $data = new User();
        $data = $data->with('roles')
            ->whereHas('roles', function ($q) {
                $q->where('name', '!=', 'MeGGi');
            });
        $data = $data->paginate(5);

        return view('livewire.user.main-index', [
            'data' => $data
        ]);
    }

    public function showForm(bool $open, $edit = false)
    {
        $this->form = $open;
        $this->reset('state');
        $this->resetErrorBag();
        $this->state = $this->params;

        if ($edit) {
            $this->state['name'] = $this->editData->name;
            $this->state['email'] = $this->editData->email;
            $this->state['password'] = "";
            $this->state['password_confirmation'] = "";
            $this->state['roles'] = $this->editData->roles->first()->name ?? "";
        } else {
            $this->reset('editData');
        }
    }

    public function actionForm()
    {
        if (isset($this->editData)) {
            $this->doUpdate();
        } else {
            $this->doCreate();
        }
    }

    public function doCreate()
    {
        $this->validate([
            'state.name' => 'required|string',
            'state.email' => 'required|string|email|unique:users,email',
            'state.password' => 'required|string|min:8|confirmed',
            'state.password_confirmation' => 'required|string',
            'state.roles' => 'required|string|exists:roles,name',
        ], [], [
            'state.name' => 'Nama Pengguna',
            'state.email' => 'Email Pengguna',
            'state.password' => 'Password Pengguna',
            'state.password_confirmation' => 'Konfirmasi Password',
            'state.roles' => 'Hak Akses',
        ]);

        DB::beginTransaction();
        try {
            $data = User::firstOrCreate([
                'name' => $this->state['name'],
                'email' => $this->state['email'],
                'password' => Hash::make($this->state['password']),
            ]);
            $data->syncRoles([$this->state['roles']]);

            DB::commit();
            $this->showForm(false);
            (new MainHelper)->doAlert(1, 'Data Penggguna Berhasil di-Tambahkan !');
        } catch (\Throwable $th) {
            DB::rollBack();
            (new MainHelper)->doAlert();
        }
    }

    public function doEdit(String $uuid)
    {
        try {
            $this->editData = User::with(['roles'])->where('uuid', '=', $uuid)->firstOrFail();
            $this->showForm(true, true);
        } catch (\Throwable $th) {
            (new MainHelper)->doAlert();
        }
    }

    public function doUpdate()
    {
        $this->validate([
            'state.name' => 'required|string',
            'state.email' => 'required|string|email|unique:users,email,' . $this->editData->id,
            'state.password' => 'nullable|string|min:8|confirmed',
            'state.password_confirmation' => 'nullable|string',
            'state.roles' => 'required|string|exists:roles,name',
        ], [], [
            'state.name' => 'Nama Pengguna',
            'state.email' => 'Email Pengguna',
            'state.password' => 'Password Pengguna',
            'state.password_confirmation' => 'Konfirmasi Password',
            'state.roles' => 'Hak Akses',
        ]);

        DB::beginTransaction();
        try {
            $data = User::where('uuid', '=', $this->editData->uuid)->firstOrFail();
            $password = $this->state['password'] != null ? Hash::make($this->state['password']) :  $data->password;

            $update = $data->update([
                'name' => $this->state['name'],
                'email' => $this->state['email'],
                'password' => $password
            ]);
            $data->syncRoles([$this->state['roles']]);

            DB::commit();
            $this->showForm(false);
            (new MainHelper)->doAlert(1, 'Data Penggguna Berhasil di-Ubah !');
        } catch (\Throwable $th) {
            DB::rollBack();
            (new MainHelper)->doAlert();
        }
    }

    public function doDelete($uuid)
    {
        DB::beginTransaction();

        try {
            $data = User::where('uuid', '=', $uuid)->firstOrFail();
            $delete = $data->delete();

            DB::commit();
            (new MainHelper)->doAlert(2, 'Data Penggguna di-Hapus !');


            if ($this->form && $this->editData->uuid === $uuid) {
                $this->showForm(false, false);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            (new MainHelper)->doAlert();
        }
    }
}
