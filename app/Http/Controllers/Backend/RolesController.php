<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
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
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function getDataTable(Request $request)
    {
        if (userCan('view roles')) {
            $modal = Role::query()->select('roles.*')->withCount('users')->with('permissions:id,name');
            return DataTables::eloquent($modal)
                ->editColumn('name', function ($role) {
                    return ucfirst($role->name);
                })
                ->editColumn('users_count',function($role){
                    return "<h5><span class='badge bg-primary'>{$role->users_count}</span></h5>";
                })
                ->rawColumns(['users_count'])
                ->toJson();
        }
    }
}
