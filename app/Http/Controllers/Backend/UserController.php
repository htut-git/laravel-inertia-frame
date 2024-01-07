<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Backend/User/UserIndex');
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $editUser = User::with('roles')->where('id', $id)->first();
        $roles = Role::select('id', 'name')->orderBy('id', 'asc')->get();
        foreach ($roles as $role) {
            if ($editUser->hasRole($role->name)) {
                $role->status = true;
            } else {
                $role->status = false;
            }
        }
        return Inertia::render('Backend/User/UserEdit', compact('editUser', 'roles'));
    }


    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);
        $user = User::find($id);
        $user->update($validatedData);
        $roles = [];
        foreach ($request->roles as $role) {
            if ($role['status']) array_push($roles, $role['name']);
        }
        $user->syncRoles($roles);
        return Inertia::render('Backend/User/UserIndex');
    }


    public function destroy(string $id)
    {
        //
    }

    public function getDataTable(Request $request)
    {
        $model = User::query()->select('users.*')->with('roles:id,name');
        return DataTables::eloquent($model)
            ->editColumn('roles', function ($user) {
                $roles = '';
                foreach ($user->roles as $role) {
                    $roles .= "<span class='badge bg-primary text-capitalize'>{$role->name}</span>";
                }
                return $roles;
            })
            ->rawColumns(['roles'])
            ->toJson();
    }
}
