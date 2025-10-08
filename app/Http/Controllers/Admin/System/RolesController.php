<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use Houtu\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return ApiResponse::success($roles, 'Role list fetched successfully');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles|max:255',
        ]);
        $data = Role::firstOrCreate($validated);

        return ApiResponse::success($data,'created successfully');
    }

    public function show($id)
    {
        $data = Role::findOrFail($id);
        return ApiResponse::success($data,'fetched successfully');
    }

    public function update(Request $request,$id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:roles,name,' . $id, // 除了当前ID外保持唯一
        ]);

        $role = Role::findOrFail($id);

        $role->update($validated);

        return ApiResponse::success($role, 'Role updated successfully');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return ApiResponse::success(null, 'Role deleted successfully');
    }


}
