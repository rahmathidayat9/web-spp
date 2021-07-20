<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function index()
    {
    	$users = User::all();
    	return view('admin.user-role.index', compact('users'));
    }

    public function create($id)
    {
    	$user = User::findOrFail($id);
    	$roles = Role::all();

    	return view('admin.user-role.create', compact('user', 'roles'));
    }

    public function store(Request $request, $id)
    {
    	$user = User::findOrFail($id);
    	$user->syncRoles($request->role);

    	return redirect()->route('user-role.index')
    		->with('success', 'Role untuk user username : '.$user->username.' berhasil disimpan!');
    }
}
