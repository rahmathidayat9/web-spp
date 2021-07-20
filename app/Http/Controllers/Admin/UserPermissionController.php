<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserPermissionController extends Controller
{
	public function index()
    {
    	$users = User::all();
    	return view('admin.user-permission.index', compact('users'));
    }

    public function create($id)
    {
    	$user = User::findOrFail($id);
    	$permissions = Permission::all();

    	return view('admin.user-permission.create', compact('user', 'permissions'));
    }

    public function store(Request $request, $id)
    {
    	$user = User::findOrFail($id);
    	$user->syncPermissions($request->permission);

    	return redirect()->route('user-permission.index')
    		->with('success', 'Permission untuk user username : '.$user->username.' berhasil disimpan!');
    }
}
