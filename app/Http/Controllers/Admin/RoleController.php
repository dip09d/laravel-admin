<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 25);
        $pagename = 'Role List';
        $title = 'Role';
        $add_button = 'Role Add';
        $query = Role::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $roles = $query->latest()->paginate($perPage);
        $roles->appends(request()->all());

        return view('admin.role.index', compact('roles', 'pagename', 'title', 'add_button'));
    }
}
