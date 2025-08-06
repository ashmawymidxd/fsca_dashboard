<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = User::where('is_super_admin', false)->paginate(10);
        return view('pages.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('pages.admins.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,id'],
            'profile_image' => ['nullable', 'image', 'max:2048'],
        ]);

        try {
            DB::beginTransaction();

            // Insert User and get the ID
            $adminId = DB::table('users')->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_super_admin' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert permissions
            if (!empty($request->permissions)) {
                $permissionData = array_map(function($permissionId) use ($adminId) {
                    return [
                        'user_id' => $adminId,
                        'permission_id' => $permissionId,
                    ];
                }, $request->permissions);

                DB::table('permission_user')->insert($permissionData);
            }

            // Handle profile image upload assets/profile_images/
            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();

                // Store in public/assets/profile_images directory
                $image->move(public_path('assets/profile_images'), $imageName);

                // Update the user with the profile image
                DB::table('users')->where('id', $adminId)->update(['profile_image' => $imageName]);
            }

            // Commit the transaction
            DB::commit();

            return redirect()->route('admins.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create admin: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $admin)
    {
        return view('pages.admins.show', compact('admin'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $admin)
    {
        if ($admin->is_super_admin) {
            abort(403, 'Super User cannot be edited.');
        }

        $permissions = Permission::all();
        return view('pages.admins.edit', compact('admin', 'permissions'));
    }

    public function update(Request $request, User $admin)
    {
        if ($admin->is_super_admin) {
            abort(403, 'Super User cannot be edited.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$admin->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        DB::transaction(function () use ($request, $admin) {
            DB::table('users')->where('id', $admin->id)->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            if ($request->password) {
                DB::table('users')->where('id', $admin->id)->update([
                    'password' => Hash::make($request->password)
                ]);
            }

            DB::table('permission_user')->where('user_id', $admin->id)->delete();
            foreach ($request->permissions as $permissionId) {
                DB::table('permission_user')->insert([
                    'user_id' => $admin->id,
                    'permission_id' => $permissionId
                ]);
            }
        });

        return redirect()->route('admins.index')->with('success', 'User updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $admin)
    {
        if ($admin->is_super_admin) {
            abort(403, 'Super User cannot be deleted.');
        }

        $admin->delete();
        return redirect()->route('admins.index')->with('success', 'User deleted successfully.');
    }
}
