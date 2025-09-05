<?php

namespace App\Http\Controllers;

use App\Models\AppItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $apps = AppItem::orderBy('created_at','desc')->get();
        return view('admin.dashboard', compact('apps'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'link' => 'nullable|url',
            'category' => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/apps');
            $data['image'] = Storage::url($path);
        }

        AppItem::create($data);
        return redirect()->route('admin.dashboard')->with('success', 'App added');
    }

    public function edit($id)
    {
        $app = AppItem::findOrFail($id);
        return view('admin.edit', compact('app'));
    }

    public function update(Request $request, $id)
    {
        $app = AppItem::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'link' => 'nullable|url',
            'category' => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/apps');
            $data['image'] = Storage::url($path);
        }

        $app->update($data);
        return redirect()->route('admin.dashboard')->with('success', 'App updated');
    }

    public function destroy($id)
    {
        $app = AppItem::findOrFail($id);
        $app->delete();
        return back()->with('success', 'App deleted');
    }

    // Show change password form (could return a view or JSON fragment)
    public function showChangePassword()
    {
        return view('admin.change-password');
    }

    // Handle change password
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($data['password']);
        $user->save();

        return back()->with('success', 'Password updated successfully');
    }
}
