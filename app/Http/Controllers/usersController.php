<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Harian;
use App\Models\UjianTahsin;
use App\Imports\UsersImport;
use App\Models\TahsinHarian;
use App\Models\UjianTahfidz;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class usersController extends Controller
{
    public function index()
    {
        $search = request()->input('search');
        $data = User::when($search, function ($query) use ($search) {
                    return $query->where('name', 'LIKE', '%'.$search.'%')
                        ->orWhere('email', 'LIKE', '%'.$search.'%')
                        ->orWhere('telepon', 'LIKE', '%'.$search.'%')
                        ->orWhere('username', 'LIKE', '%'.$search.'%')
                        ->orWhereHas('roles', function ($query) use ($search) {
                            $query->where('name', 'LIKE', '%'.$search.'%');
                        });
                })
                ->orderBy('name', 'ASC');

        return view('users.index', [
            'title' => 'Users',
            'data_user' => $data->paginate(10)->withQueryString()
        ]);
    }

    public function tambahUsers()
    {
        return view('users.tambah',[
            "title" => 'Tambah User',
            "roles" => Role::orderBy('name')->get()
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv|max:5000'
        ]);
        
        $file = $request->file('file');
        $nama_file = $file->getClientOriginalName();
        $file->move('user', $nama_file);

        Excel::import(new UsersImport, public_path('/user/'.$nama_file));
        return back()->with('success', 'Data Berhasil Di Import');
    }

    public function tambahUserProses(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'foto' => 'image|file|max:10240',
            'email' => 'required|email:dns|unique:users',
            'telepon' => 'required',
            'username' => 'required|max:255|unique:users',
            'password' => 'required|min:6|max:255',
        ]);

        if ($request->file('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('foto');
        }

        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);

        if ($request["roles"]) {
            foreach($request["roles"] as $role){
                $user->assignRole($role);
            }
        }
        
        return redirect('/users')->with('success', 'Data Berhasil di Tambahkan');
    }

    public function detail($id)
    {
        $user = User::find($id);
        return view('users.edituser', [
            'title' => 'Detail User',
            'user' => $user,
            "roles" => Role::orderBy('name')->get(),
            'userRoles' => $user->roles->pluck('name')->toArray()
        ]);
    }

    public function editUserProses(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:255',
            'foto' => 'image|file|max:10240',
            'telepon' => 'required',
            'password' => 'required',
        ];


        $userId = User::find($id);

        if ($userId->roles) {
            foreach($userId->roles as $r){
                $userId->removeRole($r->name);
            }
        }

        if ($request->email != $userId->email) {
            $rules['email'] = 'required|email:dns|unique:users';
        }

        if ($request->username != $userId->username) {
            $rules['username'] = 'required|max:255|unique:users';
        }

        $validatedData = $request->validate($rules);

        if ($request->file('foto')) {
            if ($request->foto_lama) {
                Storage::delete($request->foto_lama);
            }
            $validatedData['foto'] = $request->file('foto')->store('foto');
        }


        User::where('id', $id)->update($validatedData);

        if ($request["roles"]) {
            foreach($request["roles"] as $role){
                $userId->assignRole($role);
            }
        }
        $request->session()->flash('success', 'Data Berhasil di Update');
        return redirect('/users');
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $siswa = Siswa::where('user_id', $id)->count();
        $harian_tahfidz = Harian::where('user_id', $id)->count();
        $ujian_tahfidz = UjianTahfidz::where('user_id', $id)->count();
        $tahsin_harian = TahsinHarian::where('user_id', $id)->count();
        $ujian_tahsin = UjianTahsin::where('user_id', $id)->count();

        if ($siswa > 0 || $harian_tahfidz > 0 || $ujian_tahfidz > 0 || $tahsin_harian > 0 || $ujian_tahsin > 0) {
            Alert::error('Failed', 'Terdapat Data Siswa / Data Tahfidz / Data Tahsin Yang Menggunakan User Ini!');
            return back();
        } else {
            Storage::delete($user->foto);
            $user->delete();
            return redirect('/users')->with('success', 'Data Berhasil di Delete');
        }
    }

    public function editpassword($id)
    {
        return view('users.editpassword', [
            'title' => 'Edit Password',
            'user' => User::find($id)
        ]);
    }

    public function editPasswordProses(Request $request, $id)
    {
        $validatedData = $request->validate([
            'password' => 'required|min:6|max:255',
        ]);

        $validatedData['password'] = Hash::make($request->password);

        User::where('id', $id)->update($validatedData);
        $request->session()->flash('success', 'Password Berhasil Diganti');
        return redirect('/users');
    }

    public function myProfile()
    {
        return view('users.myProfile', [
            'title' => 'My Profile'
        ]);
    }

    public function myProfileUpdate(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:255',
            'foto' => 'image|file|max:10240',
            'telepon' => 'required',
        ];


        $userId = User::find($id);
       
        if ($request->email != $userId->email) {
            $rules['email'] = 'required|email:dns|unique:users';
        }

        if ($request->username != $userId->username) {
            $rules['username'] = 'required|max:255|unique:users';
        }

        $validatedData = $request->validate($rules);

        if ($request->file('foto')) {
            if ($request->foto_lama) {
                Storage::delete($request->foto_lama);
            }
            $validatedData['foto'] = $request->file('foto')->store('foto');
        }


        User::where('id', $id)->update($validatedData);
        
        $request->session()->flash('success', 'Data Berhasil di Update');
        return redirect('/my-profile');
    }

    public function myProfileEditPassword()
    {
        return view('users.myProfileEditPassword', [
            'title' => 'Edit Password'
        ]);
    }

    public function myProfileUpdatePassword(Request $request, $id)
    {
        $validatedData = $request->validate([
            'password' => 'required|min:6|max:255',
        ]);

        $validatedData['password'] = Hash::make($request->password);

        User::where('id', $id)->update($validatedData);
        $request->session()->flash('success', 'Password Berhasil Diganti');
        return redirect('/my-profile');
    }
}
