<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Backend\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

use function App\Helpers\userCan;

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
        $userService = new UserService($editUser);
        $sessions = $userService->sessions();
        $roles = Role::select('id', 'name')->orderBy('id', 'asc')->get();
        foreach ($roles as $role) {
            if ($editUser->hasRole($role->name)) {
                $role->status = true;
            } else {
                $role->status = false;
            }
        }
        return Inertia::render('Backend/User/UserEdit', compact('editUser', 'roles', 'sessions'));
    }


    public function update(Request $request, string $id)
    {
        if (userCan('manage users')) {
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
            return to_route('admin.users.index');
        }
    }

    function updatePassword(Request $request, string $id)
    {
        $request->validate([
            'newPassword'=>'required|string|max:255'
        ]);
        if (userCan('manage users')) {
            $user = User::find($id);
            $user->password = Hash::make($request->newPassword);
            $user->update();
        }
        return redirect()->back();
    }

    function destroySession($id)  {
        $userService = new UserService(User::find($id));
        $userService->destroySessions();
        return redirect()->back();
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
                    $roles .= "<span class='bg-blue-100 capitalize text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5
                    rounded dark:bg-blue-900 dark:text-blue-300'>{$role->name}</span>";
                }
                return $roles;
            })
            ->rawColumns(['roles'])
            ->toJson();
    }
}
