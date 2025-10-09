<?php

namespace App\Http\Controllers\Admin\System;

use App\Services\System\MenuService;
use Houtu\Base\BaseController;
use Illuminate\Http\Request;

class MenuController extends BaseController
{
    protected MenuService $services;
    public function __construct(MenuService $services)
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
            'name' => 'required|unique:menus|max:100',
            'title' => 'required|max:100',
        ]);
        $data = $this->services->store($validated);

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
            'name' => 'required|unique:menus|max:100',
            'title' => 'required|max:100',
        ]);

        $data = $this->services->update($id, $validated);

        return $this->success($data);
    }

    public function destroy($id)
    {
        $data = $this->services->destroy($id);
        return $this->success($data);
    }
}
