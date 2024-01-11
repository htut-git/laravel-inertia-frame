<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

use function App\Helpers\userCan;

class RolesController extends Controller
{

    public function index()
    {
        return Inertia::render('Backend/Role/RoleIndex');
    }

    public function create()
    {
        $permissions = Permission::all()->each(function ($query) {
            $query->status = false;
        });
        return Inertia::render('Backend/Role/RoleCreate', ['permissions' => $permissions]);
    }


    public function store(Request $request)
    {
        if (userCan('manage roles')) {
            $validData = $request->validate([
                'name' => 'required',
                'permissions' => 'required'
            ]);
            $this->saveRole($validData);
            return to_route('admin.roles.index');
        }
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
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


    public function update(Request $request, string $id)
    {
        if (userCan('manage roles')) {
            $validData = $request->validate([
                'name' => 'required',
                'permissions' => 'required'
            ]);
            $this->saveRole($validData,$id);
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

    public function getDataTable(Request $request)
    {
        if (userCan('view roles')) {
            $modal = Role::query()->select('roles.*')->withCount('users')->with('permissions:id,name');
            return DataTables::eloquent($modal)
                ->editColumn('name', function ($role) {
                    return ucfirst($role->name);
                })
                ->addColumn('users_count_html', function ($role) {
                    return "<h5><span class='badge bg-primary'>{$role->users_count}</span></h5>";
                })
                ->rawColumns(['users_count_html'])
                ->toJson();
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
