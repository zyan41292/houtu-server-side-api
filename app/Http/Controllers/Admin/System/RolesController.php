<?php

namespace App\Http\Controllers\Admin\System;

use App\Services\System\RolesService;
use Houtu\Base\BaseController;
use Illuminate\Http\Request;

class RolesController extends BaseController
{
    protected RolesService $services;

    public function __construct(RolesService $services)
    {
        $this->services = $services;
    }

    public function index()
    {
        $data = $this->services->all();

        return $this->success($data);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles|max:255',
        ]);
        $data = $this->services->firstOrCreate($validated);

        return $this->success($data);
    }

    public function show($id)
    {
        $data = $this->services->findOrFail($id);
        return $this->success($data);
    }

    public function update(Request $request,$id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:roles,name,' . $id,
        ]);

        $data = $this->services->update($id, $validated);

        return $this->success($data);
    }

    public function destroy($id)
    {
        $data = $this->services->destroy($id);
        return $this->success($data);
    }

    //todo status function


}
