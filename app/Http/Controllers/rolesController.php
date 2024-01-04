<?php

namespace App\Http\Controllers;

use App\Models\groups;
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
            $permissions = $request->input('permission', []);
            groups::create(
                [
                    'group_name' => $request->input('role_name'),
                    'permissions' => serialize($permissions)
                ]
            );
            $data = groups::all();
            session()->flash('success', 'Role Created');
            return redirect()->route('/admin/roles')->with(['data' => $data]);
        }


        $data = groups::all();
        return redirect()->route('/admin/roles')->with(['data' => $data]);
    }

    public function delete_roles(Request $request)
    {
        $role = groups::find($request->input('row_id'));
        if ($role->group_name == 'superadmin') {
            $data = groups::all();
            return redirect()->route('/admin/roles')->with(['success' => 'Cannot delete superadmin', 'data' => $data]);
        }
        $role->delete();
        $data = groups::all();
        session()->flash('success', 'Role Deleted');
        return redirect()->route('/admin/roles')->with(['success' => 'Role deleted successfully', 'data' => $data]);
    }



    public function update_roles_index($id)
    {
        $data = groups::where('id', $id)->first();
        if ($data->id == 1) {
            return redirect()->back();
        } else {
            $data = array(
                'pageTitle' => 'PRIVATECH-USER ROLES',
                'group_id' => $id,
                'group_data' => $data,
            );
            return view('frontend.admin.pages.roles.update-roles')->with(['data' => $data]);
        }
    }


    public function update_roles(Request $request)
    {
        $role = groups::where('id', $request->input('row_id'))->first();
        if ($role) {
            $validatedData = $request->validate([
                'role_name' => 'required|string|max:255',
                'permission' => 'nullable|array',
            ]);
            $role->group_name = $validatedData['role_name'];
            $role->permissions = serialize($validatedData['permission'] ?? []);
            $role->save();

            $data = groups::all();
            session()->flash('success', 'Role Updated');
            return redirect()->route('/admin/roles')->with(['data' => $data]);
        }


        return redirect()->back()->with('error', 'Role not found');
    }
}
