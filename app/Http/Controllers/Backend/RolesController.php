<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use function App\Helpers\userCan;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Backend\RoleModalRequest;

class RolesController extends Controller
{

    public function index(RoleModalRequest $request)
    {
        return Inertia::render(
            'Backend/Role/RoleIndex',
            [
                'roles' => Role::select('roles.*')->get()->each(function ($role) {
                    try {
                        $role->count_users = $role->users->count();
                        $role->show_users = $role->users->take(3);
                    } catch (\Throwable $th) {
                        $role->count_users = 0;
                        $role->show_users = [];
                    }
                })
            ]
        );
    }

    public function create()
    {
        $permissions = Permission::all()->each(function ($query) {
            $query->status = false;
        });
        return Inertia::render('Backend/Role/RoleCreate', ['permissions' => $permissions]);
    }


    public function store(RoleModalRequest $request)
    {
            $validData = $request->validate([
                'name' => 'required',
                'permissions' => 'required',
            ]);
            $this->saveRole($validData);
            return to_route('admin.roles.index');
    }


    public function show(string $id,RoleModalRequest $request)
    {
        //
    }


    public function edit(RoleModalRequest $request,string $id)
    {
        $role = Role::find($id);
        $permissions = Permission::select('id', 'name')->orderBy('id', 'asc')->get()->each(function ($query) use ($role) {
            if ($role->hasPermissionTo($query->name)) {
                $query->status = true;
            } else {
                $query->status = false;
            }
        });
        return Inertia::render('Backend/Role/RoleEdit', compact('role', 'permissions'));
    }


    public function update(RoleModalRequest $request, string $id)
    {
        if (userCan('manage roles')) {
            $validData = $request->validate([
                'name' => 'required',
                'permissions' => 'required'
            ]);
            $this->saveRole($validData, $id);
            return to_route('admin.roles.index');
        }
    }

    public function destroy(string $id)
    {
        if (userCan('manage roles')) {
            $role = Role::find($id);
            $role->syncPermissions([]);
            $role->delete();
            return back();
        }
    }


    private function saveRole($validData, $id = null)
    {
        $role = new Role();
        if ($id) {
            $role = Role::find($id);
        }
        $role->name = $validData['name'];
        $role->save();
        $permissions = [];
        foreach ($validData['permissions'] as $permission) {
            if ($permission['status']) array_push($permissions, $permission['name']);
        }
        $role->syncPermissions($permissions);
    }
}
