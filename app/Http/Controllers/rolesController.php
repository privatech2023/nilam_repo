<?php

namespace App\Http\Controllers;

use App\Models\roles;
use Illuminate\Http\Request;

class rolesController extends Controller
{
    public function create_roles(Request $request)
    {
        $validatedData = $request->validate([
            'permission' => 'nullable|array',
        ]);
        if ($request->input('role_name') != null) {
            $newRole = roles::create(['name' => $request->input('role_name')]);
            $data = roles::all();
            return view('frontend.admin.pages.roles.index')->with(['data' => $data]);
        }
        $permissions = $request->input('permission', []);
        foreach ($permissions as $permission) {
            preg_match('/(\w+)_(\d+)/', $permission, $matches);
            if (count($matches) === 3) {
                $permissionType = $matches[1];
                $roleId = $matches[2];
                $role = roles::find($roleId);
                if ($role) {
                    $role->{$permissionType} = true;
                    $role->save();
                } else {
                    echo "role not found";
                }
            }
        }
        $data = roles::all();
        return redirect()->route('/admin/roles')->with(['success' => 'Role deleted successfully', 'data' => $data]);
    }

    public function delete_roles(Request $request)
    {
        $role = roles::find($request->input('row_id'));
        $role->delete();
        $data = roles::all();
        return redirect()->route('/admin/roles')->with(['success' => 'Role deleted successfully', 'data' => $data]);
    }
}
