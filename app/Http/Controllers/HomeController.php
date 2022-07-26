<?php

namespace App\Http\Controllers;

use App\Models\User;
use Footman\Acl\Permission;
use Illuminate\Http\Request;
use Footman\Acl\Role;

class HomeController extends Controller
{
    public function index()
    {
        // $permissions = Permission::getAllPermissions();
        // $role = Role::find(1);
        // $role->givPermissionTo($permissions);

        $role = Role::find(1);
        $permission = Permission::find(1);
        $user = User::find(1);
        
        $role->assignRole($user);

        // $role->getAllRoles();
        // $permission = Permission::find(1);
        // $role = Role::getAllRoles();
        return response()->json([
            // 'data' => $role->getPermissions(),
            'data' => $role,
            'message' => true,
        ]);
        // return response()->json([
        //     'data' => Permission::getAllPermissions(),
        //     'message' => true,
        // ]);
    }

    public function store(Request $request)
    {
        $role = new Role();
        $role->name = $request->input('name');
        $role->save();

        return response()->json([
            'data' => null,
            'message' => true,
        ]);
    }
}
