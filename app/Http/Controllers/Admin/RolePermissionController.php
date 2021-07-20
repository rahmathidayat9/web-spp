<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
	public function index()
    {
    	$roles = Role::all();
    	return view('admin.role-permission.index', compact('roles'));
    }

    public function create($id)
    {
    	$role = Role::findOrFail($id);
    	$permissions = Permission::all();
    	return view('admin.role-permission.create', compact('role', 'permissions'));
    }

    public function store(Request $request, $id)
    {
    	$role = Role::findOrFail($id);
    	$role->syncPermissions($request->permission);

    	return redirect()->route('role-permission.index')
    		->with('success', 'Permission pada Role : '.$role->name.' berhasil disimpan!');
    }
}
