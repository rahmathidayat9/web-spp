<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
	public function index()
	{
		return view('profile');
	}

	public function update(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'old_password' => 'required',
			'new_password' => 'required|min:5',
		], [
			'old_password.required' => 'Password sekarang harus diisi!',
			'new_password.required' => 'Password baru harus diisi!',
			'new_password.min' => 'Password baru harus lebih dari 5 karakter!',
		]);

		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		}

		if (!Hash::check($request->new_password, Auth::user()->password)) {
			if (Hash::check($request->old_password, Auth::user()->password)) {
				User::findOrFail(Auth::user()->id)->update([
					'password' => Hash::make($request->new_password),
				]);

				return redirect()->route('home.index')->with('success', 'Password anda berhasil diubah!');
			}else{
				return back()->with('error', 'Password sekarang salah!');
			}
		}else{
			return back()->with('error', 'Password baru tidak boleh sama dengan password sekarang');
		}
	}
}
