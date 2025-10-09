<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Menu extends Model
{
    protected $table = 'menus';
    protected $fillable = [
        'name',
        'title',
        'url',
        'parent_id',
        'permission_id'
    ];

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
